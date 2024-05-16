<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulate Controller</title>
</head>

<body>
    <h1>Simulation Dashboard</h1>
    <div id="standings">
        @include('partials.standings')
    </div>
    <div id="current-week-matches">
        @include('partials.current_week_matches')
    </div>
    <div id="predictions">
        @include('partials.predictions')
    </div>
    <form id="simulateForm" action="/simulateOne">
        @csrf
        <button type="submit">Simulate</button>
    </form>
    <form id="simulateAllForm" action="/simulateAll">
        @csrf
        <button type="submit">Simulate All</button>
    </form>
    <script>
        function updateStandings() {
            fetch('/standings')
                .then(response => response.text())
                .then(data => document.getElementById('standings').innerHTML = data);
        }
        function updateCurrentWeekMatches() {
            fetch('/current-week-matches')
                .then(response => response.text())
                .then(data => document.getElementById('current-week-matches').innerHTML = data);
        }
        function updatePredictions() {
            fetch('/predictions')
                .then(response => response.text())
                .then(data => document.getElementById('predictions').innerHTML = data);
        }
        function updateAll() {
            updateStandings();
            updateCurrentWeekMatches();
            updatePredictions();
        }
        document.getElementById('simulateForm').addEventListener('submit', function (event) {
            event.preventDefault();
            fetch(this.action).then(response => {
                updateAll();
            });
        });
        document.getElementById('simulateAllForm').addEventListener('submit', function (event) {
            event.preventDefault();
            fetch(this.action).then(response => {
                updateAll();
            });
        });
        //for intial loadings
        document.addEventListener('DOMContentLoaded', function () {
            updateAll();
        });
    </script>

</body>

</html>