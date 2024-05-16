<div id="current-week-matches">
<h2>Current Week Matches</h2>
    <ul>
        @isset($currentWeekMatches)
        @if ($currentWeekMatches)
        @foreach ($currentWeekMatches as $match)
        <li>{{ $match->teamA }} vs {{ $match->teamB }}</li>
        @endforeach
        @endisset
        @endif
    </ul>
</div>