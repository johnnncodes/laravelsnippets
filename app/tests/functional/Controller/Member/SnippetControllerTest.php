<?php namespace Tests\Functional\Controller\Member;

use TestCase;
use Config;
use User;
use Snippet;
use Way\Tests\Factory;

class SnippetControllerTest extends TestCase
{
    public function testGetShowRendersNotYetApprovedSnippets()
    {
        $user = Factory::create('User');
        $this->be($user);

        $snippet = Factory::create('Snippet', array(
            'author_id' => $user->id, 'approved' => 0,
            'deleted_at' => null));

        $response = $this->call('GET', route('member.snippet.getShow', $snippet->slug));
        $this->assertResponseOk();
        $view = $response->original;
        $this->assertEquals($view['snippet']->title, $snippet->title);
    }

    public function testGetShowRendersApprovedSnippets()
    {
        $user = Factory::create('User');
        $this->be($user);

        $snippet = Factory::create('Snippet', array(
            'author_id' => $user->id, 'approved' => 1,
            'deleted_at' => null));

        $response = $this->call('GET', route('member.snippet.getShow', $snippet->slug));
        $this->assertResponseOk();
        $view = $response->original;
        $this->assertEquals($view['snippet']->title, $snippet->title);
    }

    public function testGetCreate()
    {
        $response = $this->call('GET', route('member.snippet.getCreate'));
        $this->assertResponseOk();
        $this->assertViewHas('tags');
    }

    public function testPostStoreThrowsErrorOnBlankInput()
    {
        $user = Factory::create('User');
        $this->be($user);
        $input = array();
        $response = $this->call('POST', route('member.snippet.postStore', $input));
        $this->assertRedirectedToRoute('member.snippet.getCreate');
        $this->assertSessionHas('errors');
    }

    public function testPostStoreThrowsErrorOnInvalidResourceFormat()
    {
        $user = Factory::create('User');
        $this->be($user);

        $input = array(
            'title' => 'dummy title',
            'body' => 'dummy body',
            'resource' => 'invalid resource url format'
        );

        $response = $this->call('POST', route('member.snippet.postStore', $input));
        $this->assertRedirectedToRoute('member.snippet.getCreate');
        $this->assertSessionHas('errors');
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testPostStoreThrowsExceptionOnInvalidTags()
    {
        $user = Factory::create('User');
        $this->be($user);

        # invalid tags
        $inputs = array(
            'title' => 'dummy title',
            'body' => 'dummy body',
            'tags' => array('12345') // <-- invalid tag id since no tags are on the db yet
        );

        $response = $this->call('POST', route('member.snippet.postStore'), $inputs);
    }

    public function testPostStoreSavesSnippetOnValidInput()
    {
        $user = Factory::create('User');
        $this->be($user);

        $tag = Factory::create('Tag');
        $secondTag = Factory::create('Tag');

        $input = array(
            'title' => 'dummy title',
            'body' => 'dummy body',
            'resource' => Config::get('site.url'),
            'tags' => array($tag->id, $secondTag->id)
        );

        $response = $this->call('POST', route('member.snippet.postStore'), $input);
        $this->assertRedirectedToRoute('member.snippet.getCreate');
        $this->assertSessionHas('message', "Your snippet is now submitted and waiting for admin's approval");
    }

    public function testGetEdit()
    {
        $user = Factory::create('User');
        $user->id = (string) $user->id;

        $this->be($user);

        $snippet = Factory::create('Snippet', array(
            'author_id' => $user->id, 'approved' => 1,
            'deleted_at' => null));

        $response = $this->call('GET', route('member.snippet.getEdit', $snippet->slug));

        $this->assertResponseOk();
        $view = $response->original;
        $this->assertEquals($view['snippet']->title, $snippet->title);
        $this->assertViewHas('tags');
    }

    public function testPostUpdateUpdatesSnippetOnValidInput()
    {
        $user = Factory::create('User');
        $user->id = (string) $user->id;

        $this->be($user);

        $tag = Factory::create('Tag');
        $secondTag = Factory::create('Tag');

        $snippet = Factory::create('Snippet', array(
            'author_id' => $user->id, 'approved' => 1,
            'deleted_at' => null));

        $input = array(
            'title' => 'dummy title',
            'body' => 'dummy body',
            'resource' => Config::get('site.url'),
            'tags' => array($tag->id, $secondTag->id)
        );

        $uri = route('member.snippet.postUpdate', $snippet->slug);
        $response = $this->call('POST', $uri, $input);

        $snippetFromDB = Snippet::where('slug', $snippet->slug)->first();
        $this->assertEquals($input['title'], $snippetFromDB->title);

        $this->assertRedirectedToRoute('member.snippet.getShow', $snippet->slug);
        $this->assertSessionHas('message', 'Update successful');
    }

    // public function testPostUpdateDoesntUpdateOnInvalidResourceFormat()
    // {
    //     $user = Factory::create('User');
    //     $this->be($user);

    //     $snippet = Factory::create('Snippet', array(
    //         'author_id' => $user->id, 'approved' => 1,
    //         'deleted_at' => null));

    //     $input = array(
    //         'title' => 'dummy title',
    //         'body' => 'dummy body',
    //         'resource' => 'invalid-resource-format'
    //     );

    //     $uri = route('member.snippet.postUpdate', $snippet->slug);

    //     $response = $this->call('POST', $uri, $input);

    //     // $snippetFromDB = Snippet::where('slug', $snippet->slug)->first();
    //     // $this->assertNull($snippetFromDB);

    //     // $this->assertRedirectedToRoute('member.snippet.getEdit', $snippet->slug);
    //     // $this->assertSessionHas('errors');
    // }

}
