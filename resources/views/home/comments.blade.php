@if ($comments->isNotEmpty())
    <div class="articles-slider">
        <div class="overflow-hidden">
            <h3 class="mt-4 h5 font-weight-bold float-right"><i class="fas fa-comments fa-lg mr-2"></i>نظرات آرسنالی‌ها</h3>
            <a href="{{ route('comments.list') }}" class="float-left mt-3 bg-danger px-3 py-1 text-white d-inline-block">آرشیو نظرات</a>
            <a href="{{ route('users.list') }}" class="float-left mt-3 bg-secondary px-3 py-1 text-white d-inline-block mr-1">کاربران</a>
        </div>
        <hr class="mt-0">
        <div class="card-columns">
            @foreach($comments as $comment)
                <div class="card">
                    <div class="card-body p-3">
                        <span class="card-title text-secondary"><img class="rounded-circle shadow-sm mr-2" width="30" src="{{ $comment->user->avatar }}">{{ $comment->commentable->title }}</span>
                        <p class="card-text mt-3">
                            <a href="{{ $comment->commentable->url }}" class="stretched-link">{{ str_limit(strip_tags($comment->body), 500) }}</a>
                        </p>
                        <p class="text-right mb-0">
                            <small class="eng-font text-left text-secondary font-weight-bold">{{ $comment->user->username }}</small>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
