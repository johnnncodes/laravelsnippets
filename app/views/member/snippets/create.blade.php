@extends('layouts.master')

@section('content')

  <div class="row submit-snippet-page-wrapper">

    @if($errors->has())
      <p>We encountered the following errors:</p>
      <ul>
        @foreach($errors->all() as $message)
          <li>{{ $message }}</li>
        @endforeach
      </ul>
    @endif

    <div class="col-sm-12">
      <h2 class="text-center">Submit a snippet</h2>
      <div class="account-wall">
        {{ Form::open(array('route' => 'member.snippet.postStore', 'class'=>'form-signin js-submit-snippet-form')) }}

          <div class="form-group">
            {{ Form::text('title', $value = null, array('placeholder' => 'Title', 'class'=> 'form-control', 'required' => 'required', 'autofocus' => 'autofocus' )) }}
          </div>

          <div class="form-group">
            {{ Form::textarea('description', $value = '', array('placeholder' => 'Description (optional)', 'class'=> 'form-control')) }}
            <p class="help-block"><a href="https://help.github.com/articles/github-flavored-markdown">GitHub-flavoured Markdown</a> is supported.</p>
          </div>

          <div class="form-group">
            {{ Form::textarea('body', $value = 'public static function () { echo "Hello World!"; }', array('placeholder' => 'Snippet', 'id' => 'code', 'class'=> 'form-control', 'required' => 'required')) }}
          </div>

          <div class="form-group">
            {{ Form::text('credits_to', $value = null, array('placeholder' => 'Credits to (optional)', 'class'=> 'form-control' )) }}
          </div>

          <div class="form-group">
            {{ Form::text('resource', $value = null, array('placeholder' => 'Resource url (optional), example: http://laravel.com/', 'class'=> 'form-control' )) }}
          </div>

          <div class="form-group">
            <label>Categories:</label>
            {{ Form::select('tags[]', $tags, 'S', array('multiple' => 'multiple', 'data-placeholder' => 'Choose categories', 'style' => 'width: 30%;')) }}
          </div>

          <div class="form-group">
            {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
          </div>

        {{ Form::close() }}
      </div>
    </div>
  </div>

@stop
