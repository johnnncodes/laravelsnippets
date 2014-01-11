<?php namespace LaraSnipp\Service\Form\Snippet;

use LaraSnipp\Service\Validation\AbstractLaravelValidator;

class SnippetFormLaravelValidator extends AbstractLaravelValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array(
        'title' => 'required',
        'body' => 'required',
        'resource' => 'url',
    );

}
