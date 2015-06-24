<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        App\User::create([
          'email' => 'foo@bar.com',
          'name' => 'admin',
          'password' => Hash::make('admin')
        ]);
    }
}
