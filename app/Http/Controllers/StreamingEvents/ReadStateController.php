<?php

namespace App\Http\Controllers\StreamingEvents;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReadStateController {
    public function read(string $streamingEventType, int $id) {
        return $this->update($streamingEventType, $id, true);
    }

    public function unread(string $streamingEventType, int $id) {
        return $this->update($streamingEventType, $id, false);
    }

    private function update(string $streamingEventType, int $id, bool $value)
    {
        $event = match($streamingEventType) {
            'follower' => Follower::findOrFail($id),
            default => throw new NotFoundHttpException("Event {$streamingEventType} not found"),
        };

        // TODO: authorize when auth
        // Gate::allowIf(function (User $user) {
        //     return true;
        // });

        $event->update(['read' => $value]);

        return response(status: 204);
    }
}
