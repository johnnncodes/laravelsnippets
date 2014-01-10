<?php namespace Tests\Functional\Controller;

use TestCase;
use User;
use Way\Tests\Factory;

class UserControllerTest extends TestCase
{
    public function testGetIndex()
    {
        $user = Factory::create('User', array('active' => 1));
        $secondUser = Factory::create('User', array('active' => 0));
        $this->be($user);

        $notYetApprovedSnippet = Factory::create('Snippet', array(
            'author_id' => $user->id,
            'approved' => 0,
            'deleted_at' => null));

        $approvedSnippet = Factory::create('Snippet', array(
            'author_id' => $user->id,
            'approved' => 1,
            'deleted_at' => null));

        $response = $this->call('GET', route('user.getIndex'));
        $view = $response->original;
        $this->assertResponseOk();

        # should be 1 because only 1 user is active, the 2nd user is not yet active
        $this->assertEquals(1, count($view['users']));

        # should be 1 because only 1 submitted snippet of $user is approved
        $this->assertEquals(1, $view['users'][0]->snippets_count);
    }

    public function testGetProfile()
    {
        $user = Factory::create('User', array('active' => 1));

        $response = $this->call('GET', route('user.getProfile', $user->slug));

        $view = $response->original;
        $this->assertResponseOk();
        $this->assertViewHas('user');
    }

    public function testGetSnippets()
    {
        $user = Factory::create('User', array('active' => 1));
        $this->be($user);

        $notYetApprovedSnippet = Factory::create('Snippet', array(
            'author_id' => $user->id,
            'approved' => 0,
            'deleted_at' => null));

        $approvedSnippet = Factory::create('Snippet', array(
            'author_id' => $user->id,
            'approved' => 1,
            'deleted_at' => null));

        $response = $this->call('GET', route('user.getSnippets', $user->slug));

        $this->assertResponseOk();
        $view = $response->original;

        # should be 1 because only 1 submitted snippet of $user is approved
        $this->assertEquals(1, count($view['snippets']));
        $this->assertViewHas('user');
    }

}
