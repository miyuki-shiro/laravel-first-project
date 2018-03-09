<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->truncateTables(['users','professions']);

        // $this->call(UsersTableSeeder::class);
        $this->call(ProfessionSeeder::class);
        $this->call(UserSeeder::class);
    }

    /*protected function truncateTables(array $tables)
    {
        Solo para MySql...en Postgres no funciona esta configuración;
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        foreach($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }*/
}
