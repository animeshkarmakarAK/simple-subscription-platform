<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostCreateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $websiteId;
    public string $postTitle;
    public string $postBody;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $websiteId, string $postTitle, string $postBody)
    {
        $this->websiteId = $websiteId;
        $this->postTitle = $postTitle;
        $this->postBody = $postBody;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
