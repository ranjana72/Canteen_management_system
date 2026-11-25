<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting to eSewa...</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center">

    <div class="text-center">
        <div class="w-12 h-12 border-4 border-[#0e3a8a] border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-[15px] font-semibold text-slate-700">Redirecting you to eSewa...</p>
        <p class="text-[13px] text-slate-400 mt-1">Please don't close this window.</p>
    </div>

    {{-- Auto-submitting form — eSewa requires the browser to POST these
         signed fields directly to their payment page. --}}
    <form id="esewa-form" method="POST" action="{{ $esewaUrl }}" class="hidden">
        @foreach($fields as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>

    <script>
        document.getElementById('esewa-form').submit();
    </script>

</body>
</html>