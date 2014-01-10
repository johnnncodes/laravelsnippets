<?php

class RoleSeeder extends Seeder
{
    public function run()
    {
        if (Role::count() == 0) {
            $this->generate();
        }
    }

    private function generate()
    {
        $roles = array(
            'admin',
            'member'
        );

        foreach ($roles as $role) {
            Role::create(array(
                'name' => $role
            ));
        }
    }
}
