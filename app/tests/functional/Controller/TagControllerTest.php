<?php namespace Tests\Functional\Controller;

use TestCase;
use User;
use Way\Tests\Factory;

class TagControllerTest extends TestCase
{
    public function testGetShowOnlyRendersApprovedSnippets()
    {
        $user = Factory::create('User');
        $this->be($user);

        $notYetApprovedSnippet = Factory::create('Snippet', array(
            'author_id' => $user->id,
            'approved' => 0,
            'deleted_at' => null));

        $approvedSnippet = Factory::create('Snippet', array(
            'author_id' => $user->id,
            'approved' => 1,
            'deleted_at' => null));

        $response = $this->call('GET', route('snippet.getIndex'));
        $view = $response->original;
        $this->assertEquals(count($view['snippets']), 1);
        $this->assertEquals($approvedSnippet->title, $view['snippets'][0]->title);
    }

}
