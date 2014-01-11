<?php namespace Tests\Integration\Repo;

use TestCase;
use Way\Tests\Factory;
use User;
use LaraSnipp\Repo\User\EloquentUserRepository;

class EloquentUserRepositoryTest extends TestCase
{
    public function testGetTopSnippetContributors()
    {
        $user = Factory::create('User', array('active' => 1));
        $secondUser = Factory::create('User', array('active' => 1));
        $thirdUser = Factory::create('User', array('active' => 1));

        // 1 snippet for $user
        $this->be($user);
        Factory::create('Snippet', array('author_id' => $user->id, 'approved' => 1, 'deleted_at' => null));

        // 2 snippets for $secondUser
        $this->be($secondUser);
        Factory::create('Snippet', array('author_id' => $secondUser->id, 'approved' => 1, 'deleted_at' => null));
        Factory::create('Snippet', array('author_id' => $secondUser->id, 'approved' => 1, 'deleted_at' => null));

        // 3 not yet approved snippets for $thirdUser
        $this->be($thirdUser);
        Factory::create('Snippet', array('author_id' => $thirdUser->id, 'approved' => 0, 'deleted_at' => null));
        Factory::create('Snippet', array('author_id' => $thirdUser->id, 'approved' => 0, 'deleted_at' => null));
        Factory::create('Snippet', array('author_id' => $thirdUser->id, 'approved' => 0, 'deleted_at' => null));

        $userRepo = new EloquentUserRepository(new User);
        $results = $userRepo->getTopSnippetContributors($limit = 3);

        // check if the top snippet contributor is $secondUser
        $this->assertEquals($results[0]->first_name, $secondUser->first_name);

        // check that there are only 2 snippet contributors since the snippets
        // submitted by $thirdUser is not yet approved
        $this->assertCount(2, $results);
    }

}
