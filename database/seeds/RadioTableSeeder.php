<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RadioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('radios')->delete();

        $path = base_path() . '/stations.json';

        if (!File::exists($path)) {
            throw new Exception('Invalid File');
        }

        $file = File::get($path);

        #Log::info('File:' . print_r($file, true));

        $radios = json_decode($file, true);

        DB::table('radios')->insert($radios);

        #$faker = Faker\Factory::create();
        #App\Radio::truncate();

        /*
        foreach(range(1, 30) as $index)
        {
            App\Radio::create([
                'name' => $faker->sentence,
                'description' => $faker->paragraph(4),
                'stream_url' => $faker->sentence
            ]);
        }
         */
    }
}

