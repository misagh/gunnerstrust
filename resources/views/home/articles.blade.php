@if (! empty($pinned))
    <div class="card shadow bg-dark">
        <div class="card-body p-1">
            <div class="row">
                <div class="col-md-7 col-lg-7 order-0 order-md-1">
                    <img src="{{ get_cover($pinned->cover) }}" alt="{{ $pinned->summary }}">
                </div>
                <div class="col-md-5 col-lg-5 pl-lg-0 pl-lg-4 pl-md-3 text-white order-1 order-md-0">
                    <div class="d-lg-flex flex-column h-100 mt-3 mt-lg-4 px-3 px-md-0">
                        <h2 class="font-weight-bold h4 text-center article-title">
                            <a href="{{ route('articles.view', $pinned->slug) }}" class="stretched-link">{{ $pinned->title }}</a>
                        </h2>
                        <hr class="d-none d-lg-block bg-secondary mx-3 mt-4">
                        <p class="mt-3 mt-md-3 text-justify px-md-3">{{ $pinned->summary }}</p>
                        <div class="mt-auto text-center mb-4 d-none d-lg-block">
                            <div class="mb-3">
                                <span class="bg-secondary py-2 px-3">مطالعه و ارسال نظر</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if ($articles->isNotEmpty())
    <div class="articles-slider">
        <div class="overflow-hidden">
            <h3 class="mt-4 h5 font-weight-bold float-right"><i class="fas fa-futbol fa-lg mr-2"></i>آخرین اخبار باشگاه آرسنال</h3>
            <a href="{{ route('articles.lists') }}" class="float-left mt-3 bg-success px-3 py-1 text-white">آرشیو اخبار</a>
        </div>
        <hr class="mt-0">
        <div class="main-carousel mt-3"
             data-flickity='{ "cellAlign": "center", "freeScroll": true, "wrapAround": true, "autoPlay": 2500, "pauseAutoPlayOnHover": true, "rightToLeft": true, "pageDots": false, "percentPosition": false }'>
            @foreach($articles as $article)
                <div class="carousel-cell">
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
