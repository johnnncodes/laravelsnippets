<?php namespace LaraSnipp\Service\Form\Snippet;

use LaraSnipp\Service\Validation\AbstractLaravelValidator;

class SnippetFormLaravelValidator extends AbstractLaravelValidator
{
    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = [
        'creating' => [
            'title' => 'required',
            'body' => 'required',
            'resource' => 'url'
        ],
        'updating' => [
            'title' => 'required',
            'body' => 'required',
            'resource' => 'url'
        ]
    ];
}
