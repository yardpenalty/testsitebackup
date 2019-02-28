<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticleTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
		DB::table('articles')->delete();
        $this->command->info('Articles stable deleted!');
        DB::table('articles')->updateOrInsert(['title' => 'Sample Article','user_id' => 1,'category_id' => 1,'bread_crumb' => 'dot dot dot','content' => 'Loren Ipsum','image_url' => '/assets/images/','image' =>'logo.png']);
        $this->command->info('Articles table seeded!');  
  }
}
