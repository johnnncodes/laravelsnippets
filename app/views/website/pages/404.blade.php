@extends('layouts.master')

@section('content')

    <div class="band text-center">
        <h1>404</h1>
        <h2>We lost your page or maybe it didn't ever exist</h2>
        <h3>Care to go <a href="{{route('home')}}">home?</a></h3>
    </div>

@stop