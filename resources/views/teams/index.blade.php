<!DOCTYPE html>
<html>
<head>
    <title>Teams List</title>
</head>
<body>
    <h1>Teams List</h1>

    <ul>
        @foreach ($teams as $team)
            <li>{{ $team->name }}</li>
        @endforeach
    </ul>

    <form method="post" action="{{ route('teams.start') }}">
        @csrf
        @method('POST')
        <button type="submit">Generate Fixtures</button>
    </form>
</body>
</html>
