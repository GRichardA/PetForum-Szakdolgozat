<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventApiController extends Controller
{
    public function index(): JsonResponse
    {
        $events = Event::query()
            ->with(['category', 'user'])
            ->orderBy('event_date', 'asc')
            ->get()
            ->map(function (Event $event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'event_date' => optional($event->event_date)->toDateTimeString(),
                    'location' => $event->location,
                    'description' => $event->description,
                    'category' => [
                        'id' => $event->category?->id,
                        'name' => $event->category?->name,
                        'slug' => $event->category?->slug,
                    ],
                    'user' => [
                        'id' => $event->user?->id,
                        'name' => $event->user?->name,
                    ],
                ];
            });

        return response()->json([
            'data' => $events,
            'meta' => [
                'count' => $events->count(),
            ],
        ]);
    }

    public function show(Event $event): JsonResponse
    {
        $event->load(['category', 'user', 'comments.user', 'comments.children.user']);

        return response()->json([
            'data' => [
                'id' => $event->id,
                'title' => $event->title,
                'event_date' => optional($event->event_date)->toDateTimeString(),
                'location' => $event->location,
                'description' => $event->description,
                'category' => [
                    'id' => $event->category?->id,
                    'name' => $event->category?->name,
                    'slug' => $event->category?->slug,
                ],
                'user' => [
                    'id' => $event->user?->id,
                    'name' => $event->user?->name,
                ],
                'comments' => $event->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'body' => $comment->body,
                        'user' => [
                            'id' => $comment->user?->id,
                            'name' => $comment->user?->name,
                        ],
                        'children' => $comment->children->map(function ($child) {
                            return [
                                'id' => $child->id,
                                'body' => $child->body,
                                'user' => [
                                    'id' => $child->user?->id,
                                    'name' => $child->user?->name,
                                ],
                            ];
                        })->values(),
                    ];
                })->values(),
            ],
        ]);
    }
}
