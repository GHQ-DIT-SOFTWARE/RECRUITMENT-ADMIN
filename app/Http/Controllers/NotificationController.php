<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        // Mark the notification as read
        auth()->user()->notifications->where('id', $id)->markAsRead();
        // Redirect back to the page or notifications section
        return redirect()->back();
    }
}
