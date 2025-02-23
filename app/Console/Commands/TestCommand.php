<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Order;
use App\Notifications\OrderCreated;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'app:test-command';

    protected $description = 'Command description';

    public function handle()
    {
        $order = Order::find(16);
        $formSubmission = $order->formSubmission()->with("fields.formField")->first();
        $event = Event::find(6);

        $order->notify(new OrderCreated($event, $order, $formSubmission));
    }
}
