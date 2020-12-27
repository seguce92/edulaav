<?php

use App\User;
use Illuminate\Database\Seeder;

class SyncTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'admin@admin.com')->first();

        $user->assignRole('Administrador');
    }
}
