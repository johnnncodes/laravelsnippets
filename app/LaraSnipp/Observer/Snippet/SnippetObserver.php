<?php namespace LaraSnipp\Observer\Snippet;

use Auth;

class SnippetObserver
{
    /**
     * Assign the currently user's id as the author of the snippet being created
     *
     * @param $snippet
     */
    public function creating($snippet)
    {
        $snippet->author_id = Auth::user()->id;
    }

}
