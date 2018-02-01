<?php

use Illuminate\Database\Seeder;

class PrintingTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $printing_types = [
            'Digital',
            'Flexográfica',
            'Formas Continuas'
        ];

        foreach ($printing_types as $printing_type) {
            DB::table('printing_types')->insert([
                'name' => $printing_type
            ]);
        }
    }
}
