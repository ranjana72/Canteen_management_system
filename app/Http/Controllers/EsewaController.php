<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class EsewaController extends Controller
{
    /**
     * Step 1: Build a signed payload and show an auto-submitting form
     * that POSTs the browser straight to eSewa's sandbox payment page.
     * Route: GET /student/payments/esewa/initiate/{order}
     */
    public function initiate(Order $order)
    {
        // Student can only pay for their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'You can only pay for your own orders.');
        }

        $merchantCode = config('services.esewa.merchant_code');
        $secretKey    = config('services.esewa.secret_key');

        // Unique reference for THIS payment attempt — generated before eSewa
        // ever sees it, so we can match the callback back to our record.
        $transactionUuid = (string) Str::uuid();

        $amount      = number_format($order->total_amount, 2, '.', '');
        $totalAmount = $amount; // no tax/service/delivery charges added here

        // Create a pending payment record up front so we have something
        // to update when eSewa redirects back.
        Payment::create([
            'order_id'         => $order->id,
            'user_id'          => Auth::id(),
            'amount'           => $order->total_amount,
            'method'           => 'esewa',
            'status'           => 'pending',
            'transaction_uuid' => $transactionUuid,
        ]);

        // eSewa v2 requires a signature over these three fields, in this
        // exact order, as a comma-separated "key=value" string.
        $signedFieldNames = 'total_amount,transaction_uuid,product_code';
        $message = "total_amount={$totalAmount},transaction_uuid={$transactionUuid},product_code={$merchantCode}";
        $signature = base64_encode(hash_hmac('sha256', $message, $secretKey, true));

        $fields = [
            'amount'                 => $amount,
            'tax_amount'              => '0',
            'total_amount'            => $totalAmount,
            'transaction_uuid'        => $transactionUuid,
            'product_code'            => $merchantCode,
            'product_service_charge'  => '0',
            'product_delivery_charge' => '0',
            'success_url'             => route('student.payments.esewa.success'),
            'failure_url'             => route('student.payments.esewa.failure'),
            'signed_field_names'      => $signedFieldNames,
            'signature'               => $signature,
        ];

        return view('student.payments.esewa-redirect', [
            'esewaUrl' => config('services.esewa.payment_url'),
            'fields'   => $fields,
        ]);
    }

    /**
     * Step 2: eSewa redirects the browser here after a successful payment,
     * with a base64-encoded JSON payload in ?data=
     * Route: GET /student/payments/esewa/success
     */
    public function success(Request $request)
    {
        $encoded = $request->query('data');

        if (! $encoded) {
            return redirect()->route('student.payments.index')
                ->with('error', 'Invalid response from eSewa.');
        }

        $decoded = json_decode(base64_decode($encoded), true);

        if (! $decoded || ! isset($decoded['transaction_uuid'])) {
            return redirect()->route('student.payments.index')
                ->with('error', 'Could not read the payment response from eSewa.');
        }

        $payment = Payment::where('transaction_uuid', $decoded['transaction_uuid'])->first();

        if (! $payment) {
            return redirect()->route('student.payments.index')
                ->with('error', 'Payment record not found for this transaction.');
        }

        // Verify the signature eSewa sent back matches what we'd expect,
        // so a tampered redirect can't fake a successful payment.
        $secretKey = config('services.esewa.secret_key');
        $signedFieldNames = $decoded['signed_field_names'] ?? '';
        $fieldsToSign = explode(',', $signedFieldNames);

        $message = collect($fieldsToSign)
            ->map(fn ($field) => "{$field}=" . ($decoded[$field] ?? ''))
            ->implode(',');

        $expectedSignature = base64_encode(hash_hmac('sha256', $message, $secretKey, true));

        if (! hash_equals($expectedSignature, $decoded['signature'] ?? '')) {
            return redirect()->route('student.payments.index')
                ->with('error', 'Payment verification failed (signature mismatch).');
        }

        // Double-check with eSewa's status API directly, rather than trusting
        // the redirect alone — this confirms the payment with eSewa's servers.
        $verified = $this->verifyWithEsewa(
            $decoded['product_code'],
            $decoded['total_amount'],
            $decoded['transaction_uuid']
        );

        if (! $verified) {
            $payment->update(['status' => 'failed']);

            return redirect()->route('student.payments.index')
                ->with('error', 'eSewa could not confirm this payment as complete.');
        }

        $payment->update([
            'status'         => 'paid',
            'transaction_id' => $decoded['transaction_code'] ?? null,
            'paid_at'        => now(),
        ]);

        return redirect()->route('student.payments.show', $payment)
            ->with('success', 'Payment successful! Paid via eSewa.');
    }

    /**
     * Step 2b: eSewa redirects here if the user cancels or the payment fails.
     * Route: GET /student/payments/esewa/failure
     */
    public function failure(Request $request)
    {
        return redirect()->route('student.payments.index')
            ->with('error', 'Payment was cancelled or failed. You can try again.');
    }

    /**
     * Calls eSewa's transaction status endpoint to confirm a payment is
     * genuinely COMPLETE, rather than trusting the browser redirect alone.
     */
    private function verifyWithEsewa(string $productCode, string $totalAmount, string $transactionUuid): bool
    {
        try {
            $response = Http::get(config('services.esewa.status_url'), [
                'product_code'     => $productCode,
                'total_amount'     => $totalAmount,
                'transaction_uuid' => $transactionUuid,
            ]);

            if (! $response->successful()) {
                return false;
            }

            $status = $response->json('status');

            return $status === 'COMPLETE';
        } catch (\Exception $e) {
            return false;
        }
    }
}