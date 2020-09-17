<div class="card shadow-sm mb-2">
    <div class="card-body px-3 pt-3 pb-2">
        <p class="update-body">{!! $update->body !!}</p>
        <div class="mb-0">
            <div class="float-left text-right small">
                @if (is_admin($auth) || is_author($auth))
                    <a href="{{ route('updates.edit', $update->id) }}" class="text-muted mr-1"><i class="fas fa-pen-square fa-lg"></i></a>
                @endif
                <a href="{{ route('users.profile', $update->user->username) }}" class="text-muted eng-font">{{ $update->user->username }}</a>
                <br>
                <span class="text-muted">{{ shamsi_human_diff($update->created_at) }}</span>
            </div>
            <div class="float-right mt-2">
                @foreach($update->categories as $category)
                    <h5 class="d-inline-block"><a href="{{ route('categories.updates', $category->slug) }}"><span class="badge badge-{{ $category->color }}">{{ $category->name }}</span></a></h5>
                @endforeach
            </div>
        </div>
    </div>
    <div class="card-footer pt-2 pb-1 px-1">
        <div class="row no-gutters text-center text-secondary">
            @if (empty($view))
            <div class="col-4 cursor-pointer">
                <a href="{{ route('updates.view', $update->id) }}" class="text-muted">
                    @if ($update->comments_count > 0)
                        <i class="fas fa-comment fa-lg"></i>
                        <span class="font-weight-bold">{{ $update->comments_count }}</span>
                    @else
                        <i class="far fa-comment fa-lg"></i>
                    @endif
                </a>
            </div>
            @endif
            <div class="col-{{ empty($view) ? 4 : 6 }}">
                <a href="https://t.me/share/url?url={{ rawurlencode(route('updates.view', $update->id)) }}" class="text-muted" target="_blank">
                    <i class="fab fa-telegram-plane fa-lg"></i>
                </a>
            </div>
            <div class="col-{{ empty($view) ? 4 : 6 }}">
                <a href="https://twitter.com/intent/tweet?text={{ rawurlencode(route('updates.view', $update->id)) }}" class="text-muted" target="_blank">
                    <i class="fab fa-twitter fa-lg"></i>
                </a>
            </div>
            @if (empty($view) && $comment = $update->comments->first())
                <hr class="my-1 mx-4 mx-md-5 w-100">
                <div class="text-left cursor-pointer">
                    <p class="mb-1 px-2">
                        <a href="{{ route('updates.view', $update->id) }}" class="text-muted">
                            <img src="{{ $comment->user->avatar }}" class="mr-2 mb-1" width="24">{{ $comment->user->username }}<br>
                            <span class="index-update-comment-body">{{ str_limit($comment->body, 58) }}<u class="ml-1">ادامه</u></span>
                        </a>
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
