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
        // Apenas roles de gestão — participantes não têm conta
        $roles = [
            [
                'name'         => 'admin',
                'display_name' => 'Administrador',
                'description'  => 'Acesso total ao painel de gestão.',
            ],
            [
                'name'         => 'organizador',
                'display_name' => 'Organizador',
                'description'  => 'Gestão de inscrições, aprovações e certificados.',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }

        // Admin padrão
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

        $this->command->info('✅ Roles e admin padrão criados.');
        $this->command->warn('⚠️  Altere a senha do admin imediatamente após o primeiro login!');
    }
}