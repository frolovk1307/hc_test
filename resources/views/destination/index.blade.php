<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Full Stack Developer practical test</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <style>
        .form-group {
            margin-bottom: 16px;
        }

        h2 {
            margin-top: 0;
        }

        select, .slider {
            width: 100%;
        }

        .slider {
            margin: 16px 0;
        }

        .block {
            max-width: 400px;
            margin: auto;
            border: 1px solid grey;
            padding: 16px;
            margin-bottom: 16px;
        }

        #handle {
            width: 3em;
            height: 1.6em;
            top: 50%;
            margin-top: -.8em;
            text-align: center;
            line-height: 1.6em;
        }
    </style>
</head>
<body>
<div class="block">
    <h2>Search options</h2>
    <div class="form-group">
        <label for="destination-name">Place</label>
        <select id="destination-name">
            @foreach($destinationNames as $destinationName)
                <option value="{{ $destinationName }}">{{ $destinationName }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="destination-radius">Range (km)</label>
        <div id="destination-radius" class="slider">
            <div id="handle" class="ui-slider-handle"></div>
        </div>
    </div>
</div>
<div class="block">
    <h2>Results</h2>
    <div id="results-list"></div>
</div>

<script defer>
    $(document).ready(function () {
        const handle = $('#handle');
        $('#destination-radius').slider({
            create: function () {
                handle.text($(this).slider('value'));
            },
            slide: function (event, ui) {
                handle.text(ui.value);
                //after value changed
                setTimeout(function () {
                    updateResults();
                });
            },
            min: 0,
            max: {{ $maxRadiusValue }},
        });
    });

    $(document).on('change', '#destination-name', function () {
        updateResults();
    });

    const updateResults = function () {
        //todo debounce
        const place = $('#destination-name').val();
        const radius = $('#destination-radius').slider('option', 'value');

        $.ajax({
            url: '{{ route('api.destinations.index') }}',
            data: {
                place: place,
                radius: radius,
            },
        }).done(function (result) {
            let html = '';
            $.each(result.data, function (key, value) {
                html += `<div>${key + 1}. ${value.name} (${value.range} km)</div>`;
            });
            $('#results-list')[0].innerHTML = html;
        });
    };
</script>
</body>
</html>
