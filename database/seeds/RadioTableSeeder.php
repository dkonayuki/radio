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

        $radios = array(
            ['name' => 'BBC 1', 'stream_url' => 'http://bbcwssc.ic.llnwd.net/stream/bbcwssc_mp1_ws-eieuk', 'description' => ''],
            ['name' => 'BBC 2', 'stream_url' => 'http://bbcwssc.ic.llnwd.net/stream/bbcwssc_mp1_ws-eieuk', 'description' => ''],
        );

        DB::table('radios')->insert($radios);

        $faker = Faker\Factory::create();
        #App\Radio::truncate();

        foreach(range(1, 30) as $index)
        {
            App\Radio::create([
                'name' => $faker->sentence,
                'description' => $faker->paragraph(4),
                'stream_url' => $faker->sentence
            ]);
        }
    }
}

