<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body>
        <div>
            <h1>It's welcome page.</h1>
            <a href="{{ route('destinations.index') }}">
                <button>Destination search</button>
            </a>
        </div>
    </body>
</html>
