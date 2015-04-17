@extends('layouts.master')

@section('content')

    <div class="band">
        <div class="row">

            <div class="col-md-9">
                <h1>All Snippets</h1>

                @if(Request::has('q') && Request::get('q') !== '')
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <h2>You searched for:</h2>
                        </div>
                        <div class="col-md-8">
                            @include('partials.searchForm', ['formClass' => 'form-horizontal'])
                        </div>
                    </div>
                @endif

                {{ HTML::snippets($snippets) }}
            </div>

            @include('partials/sidebars/default')

        </div>
    </div>

@stop