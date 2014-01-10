<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * Prepare for tests
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->prepareForTests();
    }

    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require __DIR__.'/../../bootstrap/start.php';
    }

    /**
     * Migrates the database.
     *
     */
    private function prepareForTests()
    {
        Artisan::call('migrate:reset');
        Artisan::call('migrate');

        Eloquent::unguard();

        // create roles
        $this->generateRoles();

        Eloquent::reguard();

        // reset redis db
        App::make('redis')->flushAll();
    }

    public function generateRoles()
    {
        Role::truncate();

        Role::create(array(
            'name' => 'admin'
        ));

        Role::create(array(
            'name' => 'member'
        ));
    }

    /**
     * NOTE: this only works on PHP version 5.3.2 and above
     *
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

}
