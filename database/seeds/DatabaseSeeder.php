<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Author;
use App\Profile;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $authors = factory(Author::class, 5)->create();
        $authors->each(function ($author) {
            $author->profile()->save(factory(Profile::class)->make());
            $author->posts()->saveMany(factory(Post::class, rand(20, 30))->make());
        });
    }
}
