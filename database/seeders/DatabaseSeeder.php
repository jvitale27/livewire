<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	Storage::deleteDirectory('posts');	//borro la carpeta public/storage/posts donde almaceno imagenes
    	Storage::makeDirectory('posts');	//creo la carpeta public/storage/posts donde almaceno imagenes

        Post::factory(50)->create();
    }
}
