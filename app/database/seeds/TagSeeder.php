<?php

class TagSeeder extends Seeder
{
    public function run()
    {
        if (Tag::count() == 0) {
            $this->generate();
        }
    }

    private function generate()
    {
        $tags = array(
            'auth' => 'auth',
            'eloquent' => 'eloquent'
        );

        foreach ($tags as $name => $slug) {
            Tag::create(array(
                'name' => $name,
                'slug' => $slug
            ));
        }
    }
}
