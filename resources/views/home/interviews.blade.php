@if ($interviews->isNotEmpty())
    <div class="articles-slider">
        <div class="overflow-hidden">
            <h3 class="mt-4 h5 font-weight-bold float-right"><i class="fas fa-microphone-alt fa-lg mr-2"></i>مصاحبه با هواداران</h3>
            <a href="{{ route('interviews.lists') }}" class="float-left mt-3 bg-purple px-3 py-1 text-white">آرشیو مصاحبه‌ها</a>
        </div>
        <hr class="mt-0">
        <div class="main-carousel mt-3"
             data-flickity='{ "cellAlign": "center", "freeScroll": true, "wrapAround": true, "rightToLeft": true, "pageDots": false, "percentPosition": false }'>
            @foreach($interviews as $interview)
                <div class="carousel-cell">
                    <div class="card shadow-sm">
                        <img class="card-img-top" src="{{ get_cover($interview->cover) }}" alt="{{ $interview->summary }}">
                        <div class="card-body">
                            <h3 class="font-weight-bold h6 mb-0"><a href="{{ route('interviews.view', $interview->slug) }}" class="stretched-link">{{ $interview->title }}</a></h3>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
