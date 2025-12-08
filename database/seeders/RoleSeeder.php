<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['nom_role' => 'Administrateur'],
            ['nom_role' => 'Modérateur'],
            ['nom_role' => 'Contributeur'],
            ['nom_role' => 'Utilisateur'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}