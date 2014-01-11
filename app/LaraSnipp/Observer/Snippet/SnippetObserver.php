<?php namespace LaraSnipp\Observer\Snippet;

use Auth;

class SnippetObserver
{
    public function creating($snippet)
    {
        $snippet->author_id = Auth::user()->id;
    }

}
