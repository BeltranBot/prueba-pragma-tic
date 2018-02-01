<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ClientTableSeeder::class, 100);
        $this->call(PrinterTableSeeder::class, 100);
        $this->call(PaperTableSeeder::class, 100);
    }
}
