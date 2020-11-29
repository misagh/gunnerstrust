<div class="container mb-2 {{ request()->routeIs('home') ? 'px-2' : '' }}">
    <div class="card bg-darkblue">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="{{ get_cover($discussion->cover) }}" class="w-100">
            </div>
            <div class="col-md-8 pl-md-0 px-4 py-3">
                <div class="text-white text-center text-md-left mt-0 mt-lg-2">
                    <h3 class="font-weight-bold"><i class="fas fa-glass-cheers mr-2"></i>بحث هواداری روز</h3>
                    <p class="mt-0 mt-md-4">{{ $discussion->title }}</p>
                </div>
                <p class="mb-0 text-center text-md-right mr-md-5">
                    <a href="{{ route('discussions.view', $discussion->slug) }}" class="bg-warning text-dark py-1 px-3 stretched-link">شرکت در بحث</a>
                </p>
            </div>
        </div>
    </div>
</div>
