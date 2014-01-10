<?php namespace Tests\Functional\Controller\Member;

use TestCase;
use User;
use Snippet;
use Way\Tests\Factory;

class UserControllerTest extends TestCase
{
    public function testGetMySnippetsRendersApprovedAndNotYetApprovedSnippets()
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

        $response = $this->call('GET', route('member.user.dashboard'));
        $view = $response->original;
        $this->assertEquals(count($view['my_snippets']), 2);
    }

}
