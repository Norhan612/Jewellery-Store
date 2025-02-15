<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\OrderCreated;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderCreatedNotification;

class SendOrderCreatedNotification
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
    public function handle(OrderCreated $event): void
    {
        //
        $order = $event->order;

        $user = User::where('store_id', $order->stor_id)->first();
        $user->notify(new OrderCreatedNotification($order));

        //If you want send to array of users
        // $users = User::where('store_id', $order->stor_id)->get();
        // Notification::send($users, new OrderCreatedNotification($order));
    }
}
