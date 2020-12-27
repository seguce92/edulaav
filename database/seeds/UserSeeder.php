<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)
            ->times(1)
            ->create([
                'email' =>  'admin@admin.com',
                'password'  =>  Hash::make('secret'),
                'name'  =>  'Administrator',
                'role'  =>  'administrator'
            ]);
    }
}
