<?php

namespace App\Http\Controllers\StreamingEvents;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReadStateController {
    public function __invoke(string $streamingEventType, int $id, string $state) {
        $event = match($streamingEventType) {
            'follower' => Follower::findOrFail($id),
            // TODO: handle other events
            default => throw new NotFoundHttpException("Event {$streamingEventType} not found"),
        };

        // TODO: authorize when auth
        // Gate::allowIf(function (User $user) {
        //     return true;
        // });

        $event->update(['is_read' => $state === 'read']);

        return response(status: 204);
    }
}
