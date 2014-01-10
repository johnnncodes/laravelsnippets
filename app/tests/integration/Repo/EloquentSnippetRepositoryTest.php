<?php namespace Tests\Integration\Repo;

use TestCase;
use Way\Tests\Factory;
use Snippet;
use App;
use LaraSnipp\Repo\Snippet\EloquentSnippetRepository;

class EloquentSnippetRepositoryTest extends TestCase
{
    public function testByPage()
    {
        $user = Factory::create('User');
        $this->be($user);
        $expectedTotalItems = 4;
        $snippets = array();

        for ($i=0; $i < $expectedTotalItems; $i++) {
            $snippets[] = Factory::create('Snippet', array('author_id' => $user->id, 'approved' => 1, 'deleted_at' => null));
        }

        $snippetRepo = new EloquentSnippetRepository(
            new Snippet,
            $this->app->make('LaraSnipp\Repo\Tag\TagRepositoryInterface'),
            $this->app->make('LaraSnipp\Repo\User\UserRepositoryInterface')
        );

        $result = $snippetRepo->byPage($page=1, $limit=3, $all=false);
        $this->assertEquals($result->totalItems, $expectedTotalItems);
        $this->assertEquals(count($result->items), $limit);
    }

    public function testTotalSnippets()
    {
        $user = Factory::create('User');
        $this->be($user);

        // create 3 approved snippets
        for ($i=0; $i < 3; $i++) {
            $snippets[] = Factory::create('Snippet', array('author_id' => $user->id, 'approved' => 1, 'deleted_at' => null));
        }

        // create 1 not yet approved snippet
        Factory::create('Snippet', array('author_id' => $user->id, 'approved' => 0, 'deleted_at' => null));

        $snippetRepo = new EloquentSnippetRepository(
            new Snippet,
            $this->app->make('LaraSnipp\Repo\Tag\TagRepositoryInterface'),
            $this->app->make('LaraSnipp\Repo\User\UserRepositoryInterface')
        );

        // test totalSnippets only returns the count of approved snippets if $all = false
        $totalSnippets = $this->invokeMethod($snippetRepo, 'totalSnippets', array($all = false));
        $this->assertEquals($totalSnippets, 3);

        // test totalSnippets returns the count of all snippets (approved & not yet approved)
        $totalSnippets = $this->invokeMethod($snippetRepo, 'totalSnippets', array($all = true));
        $this->assertEquals($totalSnippets, 4);
    }

    public function testByTag()
    {
        $user = Factory::create('User');
        $this->be($user);
        $snippets = array();

        $tag = Factory::create('Tag');

        # create 4 approved snippets that is linked to $tag
        for ($i=0; $i < 4; $i++) {
            $snippet = Factory::create('Snippet', array(
                'author_id' => $user->id,
                'approved' => 1,
                'deleted_at' => null
            ));

            $snippet->tags()->attach($tag->id);

            $snippets[] = $snippet;
        }

        # snippet w/ same tag as above but is not yet approved
        $snippet = Factory::create('Snippet', array(
            'author_id' => $user->id,
            'approved' => 0,
            'deleted_at' => null
        ));

        $snippet->tags()->attach($tag->id);

        # snippet w/o a tag
        Factory::create('Snippet', array(
            'author_id' => $user->id,
            'approved' => 1,
            'deleted_at' => null
        ));

        # snippet w/ a different tag
        $snippet = Factory::create('Snippet', array(
            'author_id' => $user->id,
            'approved' => 1,
            'deleted_at' => null
        ));
        $secondTag = Factory::create('Tag');
        $snippet->tags()->attach($secondTag->id);

        $snippetRepo = new EloquentSnippetRepository(
            new Snippet,
            $this->app->make('LaraSnipp\Repo\Tag\TagRepositoryInterface'),
            $this->app->make('LaraSnipp\Repo\User\UserRepositoryInterface')
        );

        $result = $snippetRepo->byTag($tag->slug, $page = 1, $limit = 3);

        // should only have 4 total snippets for $tag because even if it really
        // has 5, only 4 snippets are approved
        $this->assertEquals(4, $result->totalItems);

        // should be 3 because we set $limit = 3 in the
        // $snippetRepo->byTag($tag->slug, $page = 1, $limit = 3); call above
        $this->assertEquals(3 , count($result->items));
    }

    public function testGetMostViewed()
    {
        $user = Factory::create('User');
        $this->be($user);
        $snippets = array();

        $tag = Factory::create('Tag');

        // create 3 approved snippets
        for ($i=0; $i < 3; $i++) {
            $snippets[] = Factory::create('Snippet', array(
                'author_id' => $user->id,
                'approved' => 1,
                'deleted_at' => null
            ));
        }

        $redis = App::make('redis');

        // add 10 hits in snippet[1]
        $redis->zIncrBy('hits', 10, $snippets[1]->id);

        // add 5 hits in snippet[2]
        $redis->zIncrBy('hits', 5, $snippets[2]->id);

        // add 1 hit in snippet[0]
        $redis->zIncrBy('hits', 1, $snippets[0]->id);

        // expected ranking:
        // 1. $snippets[1]
        // 2. $snippets[2]
        // 3. $snippets[0]

        $snippetRepo = new EloquentSnippetRepository(
            new Snippet,
            $this->app->make('LaraSnipp\Repo\Tag\TagRepositoryInterface'),
            $this->app->make('LaraSnipp\Repo\User\UserRepositoryInterface')
        );

        $snippetsResult = $snippetRepo->getMostViewed();

        $this->assertEquals($snippets[1], $snippetsResult[0]);
    }

}
