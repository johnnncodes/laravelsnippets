<?php namespace Tests\Functional\Controller;

use TestCase;
use User;
use Way\Tests\Factory;

class SnippetControllerTest extends TestCase
{
    public function testGetIndexOnlyShowsApprovedSnippets()
    {
        $user = Factory::create('User');
        $this->be($user);

        $snippet = Factory::create('Snippet', array(
            'author_id' => $user->id,
            'approved' => 1,
            'deleted_at' => null));

        $notYetApprovedSnippet = Factory::create('Snippet', array(
            'author_id' => $user->id,
            'approved' => 0,
            'deleted_at' => null));

        $response = $this->call('GET', route('snippet.getIndex'));

        $view = $response->original;
        $this->assertEquals(1, count($view['snippets']));
        $this->assertEquals($snippet->title, $view['snippets'][0]->title);
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testGetShowDoesNotRenderNotYetApprovedSnippets()
    {
        $user = Factory::create('User');
        $this->be($user);

        $snippet = Factory::create('Snippet', array(
            'author_id' => $user->id, 'approved' => 0,
            'deleted_at' => null));

        $response = $this->call('GET', route('snippet.getShow', $snippet->slug));
    }

    public function testGetShowRendersApprovedSnippets()
    {
        $user = Factory::create('User');
        $this->be($user);

        $snippet = Factory::create('Snippet', array(
            'author_id' => $user->id, 'approved' => 1,
            'deleted_at' => null));

        $response = $this->call('GET', route('snippet.getShow', $snippet->slug));
        $this->assertResponseOk();
        $view = $response->original;
        $this->assertEquals($view['snippet']->title, $snippet->title);
    }

}
