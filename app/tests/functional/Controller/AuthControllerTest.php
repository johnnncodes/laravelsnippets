<?php namespace Tests\Functional\Controller;

use TestCase;
use User;
use Hash;
use Way\Tests\Factory;

class AuthControllerTest extends TestCase
{
    public function testGetSignup()
    {
        $crawler = $this->client->request('GET', route('auth.getSignup'));
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testSuccessfulSignup()
    {
        $inputs = array(
            'username' => 'johndoe25',
            'password' => 'dummypassword',
            'password_confirmation' => 'dummypassword',
            'email' => 'johndoe@gmail.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        );

        $response = $this->call('POST', route('auth.postSignup', $inputs));
        $this->assertRedirectedToRoute('auth.getSignup');
        $this->assertSessionHas('message', 'Successfully registered. Please check your email and activate your account.');
        $user = User::where('email', '=', $inputs['email'])->first();
        $this->assertNotNull($user);
        $this->assertTrue((Hash::check($inputs['password'], $user->password)));
        $this->assertEquals('member', $user->role->name);
    }

    public function testInvalidSignup()
    {
        $response = $this->call('POST', route('auth.postSignup'));
        $this->assertRedirectedToRoute('auth.getSignup');
        $this->assertSessionHas('errors');
    }

    public function testSuccessfulAccountActivation()
    {
        // NOTE: for some reason, Ways generator doesn't respect the fillable
        // attribute of Eloquent model so active column is being filled with
        // data so I needed to specify active = 0
        // @TODO: find a better solution
        $user = Factory::create('User', array('active' => 0));
        $this->call('GET', route('auth.getActivateAccount', array($user->slug, $user->activation_key)));
        $this->assertRedirectedToRoute('home');
        $this->assertSessionHas('message', 'Your account is now activated.');
    }

    public function testInvalidAccountActivationUsingWrongKey()
    {
        // NOTE: for some reason, Ways generator doesn't respect the fillable
        // attribute of Eloquent model so active column is being filled with
        // data so I needed to specify active = 0
        // @TODO: find a better solution
        $user = Factory::create('User', array('active' => 0));
        $this->call('GET', route('auth.getActivateAccount', array($user->slug, 'wrong activation key')));
        $this->assertRedirectedToRoute('home');
        $this->assertSessionHas('message', 'Invalid activation key.');
    }

    public function testGetLogin()
    {
        $crawler = $this->client->request('GET', route('auth.getLogin'));
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testSuccessfulLogin()
    {
        $rawPassword = 'admin';
        $user = Factory::create('User', array('password' => $rawPassword, 'active' => 1));

        $inputs = array(
            'username' => $user->username,
            'password' => $rawPassword
        );

        $crawler = $this->client->request('POST', route('auth.postLogin', $inputs));
        $this->assertRedirectedToRoute('home');
    }

    public function testInvalidLoginUsingUnregisteredUser()
    {
        $inputs = array(
            'username' => 'unregistered username',
            'password' => 'password'
        );

        $crawler = $this->client->request('POST', route('auth.postLogin', $inputs));
        $this->assertRedirectedToRoute('auth.getLogin');
        $this->assertSessionHas('message', 'Wrong username or password');
    }

    public function testInvalidLoginUsingInactiveUser()
    {
        $rawPassword = 'admin';
        $user = Factory::create('User', array('password' => $rawPassword, 'active' => 0));

        $inputs = array(
            'username' => $user->username,
            'password' => $rawPassword
        );

        $crawler = $this->client->request('POST', route('auth.postLogin', $inputs));
        $this->assertRedirectedToRoute('auth.getLogin');
        $this->assertSessionHas('message', 'Wrong username or password');
    }

    public function testInvalidLoginUsingWrongCredentials()
    {
        $user = Factory::create('User', array('password' => 'admin', 'active' => 1));

        $inputs = array(
            'username' => $user->username,
            'password' => 'wrong password'
        );

        $crawler = $this->client->request('POST', route('auth.postLogin', $inputs));
        $this->assertRedirectedToRoute('auth.getLogin');
        $this->assertSessionHas('message', 'Wrong username or password');
    }

}
