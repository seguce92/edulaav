<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name'  =>  'Administrador'
        ]);

        Role::create([
            'name'  =>  'Director'
        ]);

        Role::create([
            'name'  =>  'Secretario'
        ]);

        Role::create([
            'name'  =>  'Docente'
        ]);

        Role::create([
            'name'  =>  'Estudiante'
        ]);
    }
}
