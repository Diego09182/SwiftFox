<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BulletinPublished implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $title;

    public $content;

    /**
     * Create a new event instance.
     *
     * @param  string  $title
     * @param  string  $content
     * @return void
     */
    public function __construct($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('public.bulletins');
    }

    /**
     * The data that should be broadcast with the event.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}
