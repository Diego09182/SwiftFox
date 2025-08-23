<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ResourceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $resourceType;

    protected $resourceId;

    protected $title;

    protected $reason;

    public function __construct($resourceType, $resourceId, $title, $reason)
    {
        $this->resourceType = $resourceType;
        $this->resourceId = $resourceId;
        $this->title = $title;
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    private function getPayload(): array
    {
        return [
            'resource_type' => $this->resourceType,
            'resource_id' => $this->resourceId,
            'title' => $this->title,
            'reason' => $this->reason,
        ];
    }

    public function toDatabase($notifiable)
    {
        return $this->getPayload();
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->getPayload());
    }
}
