<div id="predictions">
    <h2>Predictions</h2>
    <ul>
        @isset($predictions)
        @foreach ($predictions as $teamName => $probability)
            <li>{{ $teamName }} : {{ number_format($probability *100 ,2) }} %</li>
        @endforeach
        @endisset
    </ul>
</div>