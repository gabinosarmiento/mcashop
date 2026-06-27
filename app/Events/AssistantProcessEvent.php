<?php

namespace App\Events;

use App\Models\CommandModel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssistantProcessEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param CommandModel $process
     */
    public function __construct(public CommandModel $process) {}

    /**
     * The channel the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('assistant.process');
    }

    /**
     * The event's alias for broadcasting.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'AssistantProcessEvent';
    }
}