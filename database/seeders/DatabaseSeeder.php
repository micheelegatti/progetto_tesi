<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Resetta la cache dei permessi di Spatie (molto importante se si fa il refresh)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //Crea i permessi di base
        $p1 = Permission::create(['name' => 'write newsletter']);
        $p2 = Permission::create(['name' => 'send newsletter']);
        $p3 = Permission::create(['name' => 'manage users']);
        $p4 = Permission::create(['name' => 'view analytics']);

        // Creazione ruolo EDITOR e assegno alcuni permessi
        $editorRole = Role::create(['name' => 'editor']);
        $editorRole->givePermissionTo([$p1, $p4]);

        //Creazione ruolo ADMIN con tutti i permessi
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        //Creazione utente personale (admin)
        $admin = User::firstOrCreate(
            ['email' => 'admin@test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole($adminRole);

        //Creo un secondo utente di tipo EDITOR
        $editor = User::firstOrCreate(
            ['email' => 'editor@test'],
            [
                'name' => 'Editor',
                'password' => Hash::make('password123'),
            ]
        );
        $editor->assignRole($editorRole);
    }
}
