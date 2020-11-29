@if ($articles->isNotEmpty())
    <div class="articles-slider mb-3">
        <div class="overflow-hidden">
            <h3 class="mt-4 h5 font-weight-bold float-right"><i class="fas fa-futbol fa-lg mr-2"></i>مقالات آرسنالی</h3>
            <a href="{{ route('articles.lists') }}" class="float-left mt-3 bg-success px-3 py-1 text-white">همه مقالات</a>
        </div>
        <hr class="mt-0">
        <div class="row mt-3">
            @foreach($articles as $article)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <img class="card-img-top" src="{{ get_cover($article->cover) }}" alt="{{ $article->summary }}">
                        <div class="card-body">
                            <h3 class="font-weight-bold h6 mb-0"><a href="{{ route('articles.view', $article->slug) }}" class="stretched-link">{{ $article->title }}</a></h3>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
