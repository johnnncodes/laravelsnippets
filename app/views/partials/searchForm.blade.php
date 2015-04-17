{{Form::open(['route' => 'snippet.getIndex', 'method' => 'GET', 'class' => $formClass])}}
<div class="form-group">
    {{Form::text('q', Request::get('q') ?: '', ['class' => 'input-lg form-control', 'placeholder' => 'Looking for a snippet?'])}}
    <style>
        .search-button-homepage {
            display: none;
        }
    </style>
    {{Form::submit('search', ['class' => 'search-button-homepage'])}}
</div>
{{Form::close()}}