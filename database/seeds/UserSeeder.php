<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Profession;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$professions = DB::select('SELECT id FROM professions WHERE title = ?', 
            ['Desarrollador back-end']);
        dd($professions);*/

        /*$professionId = DB::table('professions')
            ->where('title', 'Desarrollador back-end')->value('id');

        DB::table('users')->insert([
            'name' => 'Duilio Palacios',
            'email' => 'duilio@styde.net',
            'password' => bcrypt('laravel'),
            'is_admin' => 'true',
            'profession_id' => $professionId,
        ]);

        DB::insert('INSERT INTO users (name, email, password, profession_id) 
            VALUES (:name, :email, :password, :profession_id)',[
                'name' => 'Thaimy Grande',
                'email' => 'thaimy@gmail.com',
                'password' => bcrypt('laravel'),
                'profession_id' => DB::table('professions')
                    ->where('title', 'Desarrollador front-end')->value('id'),
            ]);*/

        User::create([
            'name' => 'Duilio Palacios',
            'email' => 'duilio@styde.net',
            'password' => bcrypt('laravel'),
            'is_admin' => 'true',
            'profession_id' => Profession::where('title', 'Desarrollador back-end')
                ->value('id')]);

        User::create([
            'name' => 'Thaimy Grande',
            'email' => 'thaimy@gmail.com',
            'password' => bcrypt('laravel'),
            'profession_id' => Profession::where('title', 'Desarrollador front-end')
                ->value('id')]);
        
        User::create([
            'name' => 'Sara Smith',
            'email' => 'saraSmith@hotmail.com',
            'password' => bcrypt('laravel'),
            'profession_id' => Profession::where('title', 'Diseñador web')
                ->value('id')]);

        factory(User::class)->create([
            'profession_id' => Profession::where('title', 'Desarrollador back-end')
                ->value('id')]);

        factory(User::class)->create();
        //factory(User::class, 50)->create();
    }
}
