<?php namespace Tests\Integration\Model;

use TestCase;
use User;
use Hash;

class UserModelTest extends TestCase
{
    public function testGetFullNameAttribute()
    {
        $user = new User;
        $user->first_name = 'John';
        $user->last_name = 'Doe';

        $this->assertEquals('John Doe', $user->full_name);
    }

    public function testSetPasswordAttribute()
    {
        $user = new User;
        $user->password = 'myawesomepassword';

        $this->assertTrue((Hash::check('myawesomepassword', $user->password)));
    }

    public function testGetAbsPhotoUrlAttribute()
    {
        $user = new User;

        $user->email = 'johndoe@gmail.com';

        $this->assertNotEquals(asset('photo.png'), $user->abs_photo_url);

        $user->photo_url = 'photo.png';

        $this->assertEquals(asset('photo.png'), $user->abs_photo_url);
    }

}
