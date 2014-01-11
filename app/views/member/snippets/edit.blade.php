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
      <h2 class="text-center">Editing snippet "{{ e($snippet->title) }}"</h2>
      <div class="account-wall">
        {{ Form::model($snippet, array('route' => array('member.snippet.postUpdate', $snippet->slug), 'method' => 'POST', 'class'=>'form-signin js-submit-snippet-form')) }}

         <div class="form-group">
            {{ Form::text('title', $value = null, array('placeholder' => 'Title', 'class'=> 'form-control', 'required' => 'required', 'autofocus' => 'autofocus' )) }}
          </div>

          <div class="form-group">
            {{ Form::textarea('description', $value = null, array('placeholder' => 'Description (optional)', 'class'=> 'form-control')) }}
            <p class="help-block"><a href="https://help.github.com/articles/github-flavored-markdown">GitHub-flavoured Markdown</a> is supported.</p>
          </div>

          <div class="form-group">
            {{ Form::textarea('body', $value = null, array('placeholder' => 'Snippet', 'id' => 'code', 'class'=> 'form-control', 'required' => 'required')) }}
          </div>

          <div class="form-group">
            {{ Form::text('credits_to', $value = null, array('placeholder' => 'Credits to (optional)', 'class'=> 'form-control' )) }}
          </div>

          <div class="form-group">
            {{ Form::text('resource', $value = null, array('placeholder' => 'Resource url (optional), example: http://laravel.com/', 'class'=> 'form-control' )) }}
          </div>

          <div class="form-group">
            <label>Tags:</label>
            {{ Form::select('tags[]', $tags, $snippet->tags->lists('id'), array('multiple' => 'multiple', 'data-placeholder' => 'Choose tags', 'style' => 'width: 30%;')) }}
          </div>

          <div class="form-group">
            {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
          </div>

        {{ Form::close() }}
      </div>
    </div>
  </div>

@stop
