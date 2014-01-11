<?php namespace Tests\Functional\Controller;

use TestCase;
use Way\Tests\Factory;
use Snippet;

class HomeControllerTest extends TestCase
{
    public function testHomePageOnlyShowsApprovedSnippets()
    {
        $user = Factory::create('User');
        $this->be($user);
        $snippet = Factory::create('Snippet', array(
            'author_id' => $user->id, 'approved' => 1,
            'deleted_at' => null));

        $notYetApprovedSnippet = Factory::create('Snippet', array(
            'author_id' => $user->id,
            'approved' => 0,
            'deleted_at' => null));

        $response = $this->call('GET', '/');
        $view = $response->original;
        $this->assertEquals(count($view['snippets']), 1);
        $this->assertEquals($snippet->title, $view['snippets'][0]->title);
    }

    public function testHomePageTopSnippetContributors()
    {
        // with 2 approved and 1 not yet approved snippet
        $user = Factory::create('User', array('active' => 1));
        $this->be($user);
        Factory::create('Snippet', array('author_id' => $user->id, 'approved' => 1, 'deleted_at' => null));
        Factory::create('Snippet', array('author_id' => $user->id, 'approved' => 1, 'deleted_at' => null));
        Factory::create('Snippet', array('author_id' => $user->id, 'approved' => 0, 'deleted_at' => null));

        // with 1 not yet approved snippet
        $secondUser = Factory::create('User', array('active' => 1));
        $this->be($secondUser);
        Factory::create('Snippet', array('author_id' => $secondUser->id, 'approved' => 0, 'deleted_at' => null));

        // with 1 approved and 3 not yet approved snippets
        $thirdUser = Factory::create('User', array('active' => 1));
        $this->be($thirdUser);
        Factory::create('Snippet', array('author_id' => $thirdUser->id, 'approved' => 1, 'deleted_at' => null));
        Factory::create('Snippet', array('author_id' => $thirdUser->id, 'approved' => 0, 'deleted_at' => null));
        Factory::create('Snippet', array('author_id' => $thirdUser->id, 'approved' => 0, 'deleted_at' => null));
        Factory::create('Snippet', array('author_id' => $thirdUser->id, 'approved' => 0, 'deleted_at' => null));

        $response = $this->call('GET', '/');
        $view = $response->original;

        // only 2 is expected since we are only rendering contributors w/ approved snippets
        $this->assertEquals(count($view['topSnippetContributors']), 2);

        # rank 1 should be $user
        $this->assertEquals($view['topSnippetContributors'][0]->full_name, $user->full_name);
        $this->assertEquals($view['topSnippetContributors'][0]->snippets_count, 2);

        # rank 2 should be $thirdUser
        $this->assertEquals($view['topSnippetContributors'][1]->full_name, $thirdUser->full_name);
        $this->assertEquals($view['topSnippetContributors'][1]->snippets_count, 1);
    }

}
