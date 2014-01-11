<?php namespace Tests\Unit\Model;

use TestCase;
use User;

class UserModelTest extends TestCase
{
    public function testIsActive()
    {
        $user = new User;
        $user->active = 1;

        $this->assertTrue($user->isActive());

        $user->active = 0;
        $this->assertFalse($user->isActive());
    }

}
