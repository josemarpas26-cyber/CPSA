<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,    // 1. Roles + admin
            SpeakerSeeder::class, // 2. Palestrantes
            CursoSeeder::class,   // 3. Cursos (depende de speakers)
            InscricaoSeeder::class, // 4. Inscrições (depende de cursos)
        ]);
    }
}