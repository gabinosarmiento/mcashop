<?php

namespace App\Events;

use App\Models\CommandLogModel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssistantCommandEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param CommandLogModel $command
     */
    public function __construct(public CommandLogModel $command) {}

    /**
     * The channel the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('assistant.command');
    }

    /**
     * The event's alias for broadcasting.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'AssistantCommandEvent';
    }
}