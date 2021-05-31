<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Arr;
use App\ProductCost;

class BarcodeReceived implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * 受取データ
     *
     * @var payload
     */
    public $payload;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // $payload = $this->payload;
        // $product_cost = ProductCost::where('product_code', $payload['product_code'])
        //     ->select('product_costs.id')
        //     ->first();
        // if ($product_cost) {
        //     Arr::set($this->payload, 'product_cost_id', $product_cost->id);
        // }
        // return new PrivateChannel('barcode'.$this->payload['function'].'.'.$this->payload['product_cost_id']);
        return new PrivateChannel('barcode.'.$this->payload['user_id']);
    }
}
