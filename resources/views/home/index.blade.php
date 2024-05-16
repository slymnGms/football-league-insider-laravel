<!DOCTYPE html>
<html>
<head>
    <title>Football League Setup</title>
</head>
<body>
    <h1>Welcome to Football League Setup</h1>
    <p>Click the button below to start the setup process:</p>
    <form method="post" action="{{ route('home.start') }}">
        @csrf
        <button type="submit">Start Setup</button>
    </form>
</body>
</html>
