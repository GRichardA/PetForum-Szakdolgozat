<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Event $event)
    {
        $data = $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'parent_id' => $data['parent_id'] ?? null,
            'body' => $data['body'],
        ]);

        return redirect()->route('events.show', $event->id)->with('success', 'Hozzászólás elmentve.');
    }

    public function destroy(Request $request, Event $event, Comment $comment)
    {
        // Check if comment belongs to this event
        if ($comment->event_id !== $event->id) {
            abort(404);
        }

        // Check authorization
        if (!$comment->canBeDeletedBy(Auth::user())) {
            abort(403, 'Nincs jogosultsága ezt a hozzászólást törölni.');
        }

        $comment->delete();

        return redirect()->route('events.show', $event->id)->with('success', 'Hozzászólás törölve.');
    }
}
