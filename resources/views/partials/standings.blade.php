<div id="standings">
    <h2>Standings</h2>
    <!-- Table to display standings data -->
    <table>
        <thead>
            <tr>
                <th>Team</th>
                <th>Points</th>
                <th>Played</th>
                <th>Won</th>
                <th>Drawn</th>
                <th>Lost</th>
                <th>Goals For</th>
                <th>Goals Against</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through standings data and display rows -->
            @isset ($standings)
            @if ($standings)
                @foreach ($standings as $standing)
                    <tr>
                        <td>{{ $standing->team_name }}</td>
                        <td>{{ $standing->points }}</td>
                        <td>{{ $standing->played }}</td>
                        <td>{{ $standing->won }}</td>
                        <td>{{ $standing->drawn }}</td>
                        <td>{{ $standing->lost }}</td>
                        <td>{{ $standing->goals_for }}</td>
                        <td>{{ $standing->goals_against }}</td>
                    </tr>
                @endforeach
            @endif
            @endisset
        </tbody>
    </table>
</div>