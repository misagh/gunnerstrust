@if ($podcasts->isNotEmpty())
    <div class="articles-slider">
        <div class="overflow-hidden">
            <h3 class="mt-4 h5 font-weight-bold float-right"><i class="fas fa-podcast fa-lg mr-2"></i>پادکست هایبری</h3>
            <a href="{{ route('podcasts.lists') }}" class="float-left mt-3 bg-orange px-3 py-1 text-white">همه قسمت‌ها</a>
        </div>
        <hr class="mt-0">
        <div class="row no-gutters mt-3">
            @foreach($podcasts as $podcast)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <img class="card-img-top" src="{{ get_cover($podcast->cover) }}" alt="{{ $podcast->summary }}">
                        <div class="card-body">
                            <h3 class="font-weight-bold h6 mb-0"><a href="{{ route('podcasts.view', $podcast->slug) }}" class="stretched-link">{{ $podcast->title }}</a></h3>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
