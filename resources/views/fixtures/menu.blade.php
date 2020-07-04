<div class="card shadow alert-{{ $bg_color ?? 'success' }} text-dark mb-2">
    <div class="card-body {{ empty($compact) ? '' : 'p-3' }}">
        <div class="text-center">
            <p class="eng-font mb-3">
                <span class="mb-2 font-weight-bold team-name">{{ $fixture->team1->name_en }}</span>
                @if ($fixture->played_at > now())
                    <span> vs </span>
                @else
                    <span> {{ $fixture->score1 }} - {{ $fixture->score2 }} </span>
                @endif
                <span class="font-weight-bold team-name">{{ $fixture->team2->name_en }}</span>
            </p>
        </div>
        <div class="row justify-content-between">
            @if ($logo2 = $fixture->team2->logo)
            <div class="float-left pl-2 pl-sm-3">
                <img src="{{ $logo2 }}" class="fixture-menu-logo {{ empty($compact) ? '' : 'fixture-menu-logo-compact' }}" width="100">
            </div>
            @endif
            <div class="col text-center {{ empty($compact) ? '' : 'mt-2 pt-1' }}">
                @if (empty($compact))
                <p class="eng-font small {{ $fixture->played_at->isToday() ? 'mb-0' : '' }}">{{ $fixture->stadium->name_en }} - {{ $fixture->competition->name_en }}</p>
                @if ($fixture->played_at->isToday())
                    <div class="spinner-grow text-danger" role="status">
                        <span class="sr-only">Live</span>
                    </div>
                @endif
                <p class="mb-2">{{ shamsi_format($fixture->played_at, 'l j F - H:i') }}</p>
                @endif
                @if (empty($no_menu_link))
                <a class="btn {{ (empty($compact) ? 'btn-outline-' : 'btn-') . ($bg_color ?? 'success') }} btn-sm stretched-link" href="{{ route('fixtures.view', $fixture->slug) }}">منوی بازی</a>
                @endif
            </div>
            @if ($logo1 = $fixture->team1->logo)
            <div class="float-right pr-2 pr-sm-3">
                <img src="{{ $logo1 }}" class="fixture-menu-logo {{ empty($compact) ? '' : 'fixture-menu-logo-compact' }}" width="100">
            </div>
            @endif
        </div>
    </div>
</div>
