<?php

namespace App\Listeners;

use App\Events\LeaveStatusChanged;
use App\Notifications\LeaveStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendLeaveStatusChangedMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LeaveStatusChanged $event): void
    {
        $leave = $event->leave;
        $user = $leave->user;
        Notification::send($user, new LeaveStatusNotification($leave));
    }
}
