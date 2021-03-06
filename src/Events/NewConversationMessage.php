<?php

namespace PhpJunior\LaravelVideoChat\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewConversationMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var
     */
    public $text;
    /**
     * @var
     */
    public $channel;

    /**
     * Create a new event instance.
     *
     * @param $text
     * @param $channel
     */
    public function __construct($text , $channel)
    {
        $this->text = $text;
        $this->channel = $channel;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel($this->channel);
    }

    public function broadcastWith()
    {
        return [
            'text' => $this->text,
            'sender' => check()->user(),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];
    }
}
