<div class="flex items-start space-x-4 py-4 border-b">
    <div class="flex-shrink-0">
        <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full object-cover" />
    </div>
    <div class="flex-1">
        <div class="flex items-center justify-between">
            <div class="text-sm font-semibold text-gray-800">{{ $comment->user->name }}</div>
            <div class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
        </div>
        <div class="mt-2 text-gray-700">{!! nl2br(e($comment->body)) !!}</div>

        {{-- Reply form toggler and small reply form --}}
        @auth
            <div class="mt-2">
                <button type="button" class="text-xs text-indigo-600 hover:underline" onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')">Válasz</button>

                <form id="reply-form-{{ $comment->id }}" action="{{ route('events.comments.store', $comment->event_id) }}" method="POST" class="mt-2 hidden">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                    <textarea name="body" rows="2" class="w-full border rounded p-2 text-sm" placeholder="Írj választ..."></textarea>
                    <div class="mt-2 text-right">
                        <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">Küldés</button>
                    </div>
                </form>
            </div>
        @endauth

        @if($comment->children->count())
            <div class="mt-4 border-l pl-4">
                @foreach($comment->children as $child)
                    @include('events._comment', ['comment' => $child])
                @endforeach
            </div>
        @endif
    </div>
</div>
