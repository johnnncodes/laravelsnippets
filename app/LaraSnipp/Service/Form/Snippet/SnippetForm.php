<?php namespace LaraSnipp\Service\Form\Snippet;

use App;
use Auth;
use LaraSnipp\Service\Validation\ValidableInterface;
use LaraSnipp\Repo\Snippet\SnippetRepositoryInterface;
use LaraSnipp\Repo\Tag\TagRepositoryInterface;

class SnippetForm
{
    /**
     * Form Data
     *
     * @var array
     */
    protected $data;

    /**
     * Validator
     *
     * @var \LaraSnipp\Form\Service\ValidableInterface
     */
    protected $validator;

    /**
     * User repository
     *
     * @var \LaraSnipp\Repo\User\UserRepositoryInterface
     */
    protected $snippet;

    protected $tag;

    public function __construct(
        ValidableInterface $validator,
        SnippetRepositoryInterface $snippet,
        TagRepositoryInterface $tag)
    {
        $this->validator = $validator;
        $this->snippet = $snippet;
        $this->tag = $tag;
    }

    /**
     * Create a new snippet
     *
     * @return boolean
     */
    public function create(array $input)
    {
        if ( ! $this->valid($input)) {
            return false;
        }

        // validate if tags chosen are valid
        // @TODO: move this into a helper so we can re-use this one
        $tagIds = $this->tag->all()->lists('id');

        if (isset($input['tags']) && count($input['tags']) > 0) {
            foreach ($input['tags'] as $id) {
                if ( ! in_array($id, $tagIds)) {
                    return App::abort(404);
                }
            }
        }

        return $this->snippet->create($input);
    }

    public function update($slug, array $input)
    {
        $snippet = $this->snippet->bySlug($slug, $all = true);

        if ( ! $snippet->isTheAuthor(Auth::user())) return App::abort(404);

        if ( ! $this->valid($input) ) {
            return false;
        }

        // validate if tags chosen are valid
        // @TODO: move this into a helper so we can re-use this one
        $tagIds = $this->tag->all()->lists('id');

        if (isset($input['tags']) && count($input['tags']) > 0) {
            foreach ($input['tags'] as $id) {
                if ( ! in_array($id, $tagIds)) {
                    return App::abort(404);
                }
            }
        }

        if ( ! $this->snippet->update($snippet, $input)) return false;
        return $snippet;
    }

    /**
     * Return any validation errors
     *
     * @return array
     */
    public function errors()
    {
        return $this->validator->errors();
    }

    /**
     * Test if form validator passes
     *
     * @return boolean
     */
    protected function valid(array $input)
    {
        return $this->validator->with($input)->passes();
    }

}
