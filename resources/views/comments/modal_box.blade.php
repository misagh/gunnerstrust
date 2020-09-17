@foreach($comments as $comment)
    <div class="media">
        <a href="{{ route('users.profile', $comment->user->username) }}">
            <img class="mr-2" src="{{ $comment->user->avatar }}" alt="{{ $comment->user->username }}" width="48">
        </a>
        <div class="media-body">
            <h6 class="mt-0 font-weight-bold eng-font">
                <a href="{{ route('users.profile', $comment->user->username) }}">{{$comment->id}} - {{ $comment->user->username }}</a>
            </h6>
            <p class="mb-0">{{ $comment->body }}</p>
        </div>
    </div>
    <hr>
@endforeach
