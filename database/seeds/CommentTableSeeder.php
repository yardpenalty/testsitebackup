<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommentTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
		DB::table('comments')->delete();
        $this->command->info('comments table deleted!');
        DB::table('comments')->updateOrInsert(['article_id' => 1,'user_id' => 1,'bread_crumb' => 'dot dot dot','content' => 'Sample Comment']);
        $this->command->info('comments table seeded!');  
  }
}
