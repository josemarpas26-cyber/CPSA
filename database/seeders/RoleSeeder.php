<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // ── Roles ─────────────────────────────────
        $roles = [
            ['name' => 'admin',        'display_name' => 'Administrador'],
            ['name' => 'organizador',  'display_name' => 'Organizador'],
            ['name' => 'participante', 'display_name' => 'Participante'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }

        // ── Admin padrão ──────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'admin@cpsa2025.ao'],
            [
                'name'     => 'Administrador CPSA',
                'password' => Hash::make('Admin@2025!'),
                'telefone' => '+244900000000',
            ]
        );

        $admin->roles()->syncWithoutDetaching(
            Role::whereIn('name', ['admin', 'organizador'])->pluck('id')
        );
    }
}