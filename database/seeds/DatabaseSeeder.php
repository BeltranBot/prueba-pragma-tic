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
        $this->call(ClientTableSeeder::class);
        $this->call(PrinterTableSeeder::class);
        $this->call(PaperTableSeeder::class);
        $this->call(OperatorTableSeeder::class);
        $this->call(PrintingTypesTableSeeder::class);
    }
}
