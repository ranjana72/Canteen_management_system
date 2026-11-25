<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Management page — DataTable loads rows via notifications.data
     * Route: GET /{role}/notifications
     */
    public function index()
    {
        $view = Auth::user()->role === 'admin'
            ? 'admin.notifications.index'
            : 'kitchen.notifications.index';

        return view($view);
    }

    /**
     * Student: full list of active notifications
     * Route: GET /student/notifications
     */
    public function studentIndex()
    {
        $notifications = Notification::where('is_active', true)
            ->latest()
            ->get();

        return view('student.notifications.index', compact('notifications'));
    }

    /**
     * JSON feed for the DataTable
     * Route: GET /{role}/notifications/data
     */
    public function data()
    {
        $notifications = Notification::with('creator')
            ->latest()
            ->get()
            ->map(function ($n) {
                return [
                    'id'         => $n->id,
                    'title'      => $n->title,
                    'message'    => $n->message,
                    'is_active'  => $n->is_active,
                    'creator'    => $n->creator->name ?? '—',
                    'created_at' => $n->created_at->format('M j, Y g:i A'),
                ];
            });

        return response()->json(['data' => $notifications]);
    }

    /**
     * Create a new notification (called from the modal via AJAX)
     * Route: POST /{role}/notifications
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:150',
            'message'   => 'required|string|max:1000',
            'is_active' => 'sometimes|boolean',
        ]);

        $notification = Notification::create([
            'created_by' => Auth::id(),
            'title'      => $validated['title'],
            'message'    => $validated['message'],
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return response()->json(['success' => true, 'notification' => $notification]);
    }

    /**
     * Update an existing notification (called from the modal via AJAX)
     * Route: PUT /{role}/notifications/{notification}
     */
    public function update(Request $request, Notification $notification)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:150',
            'message'   => 'required|string|max:1000',
            'is_active' => 'sometimes|boolean',
        ]);

        $notification->update([
            'title'     => $validated['title'],
            'message'   => $validated['message'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return response()->json(['success' => true, 'notification' => $notification]);
    }

    /**
     * Delete a notification (called via SweetAlert2 confirm + AJAX)
     * Route: DELETE /{role}/notifications/{notification}
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Active notifications for the student bell dropdown (shared partial)
     * Route: GET /notifications/active
     */
    public function active()
    {
        $notifications = Notification::where('is_active', true)
            ->latest()
            ->take(10)
            ->get();

        return response()->json(['data' => $notifications]);
    }
}