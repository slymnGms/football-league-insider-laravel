<!DOCTYPE html>
<html>
<head>
    <title>Fixtures List</title>
</head>
<body>
    <h1>Fixtures List</h1>

    <table>
        <thead>
            <tr>
                <th>Week</th>
                <th>Home Team</th>
                <th>Away Team</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fixtures as $fixture)
                <tr>
                    <td>{{ $fixture->week }}</td>
                    <td>{{ $fixture->homeTeam->name }}</td>
                    <td>{{ $fixture->awayTeam->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <form method="post" action="{{ route('fixtures.start') }}">
        @csrf
        <button type="submit">Start Simulation</button>
    </form>
</body>
</html>
