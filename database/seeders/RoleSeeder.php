<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Resetta la cache dei permessi di Spatie (molto importante se si fa il refresh)
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //Creazione permessi
        $permissions = [
            'write newsletter',
            'manage users',
            'view analytics',
            'create list',
            'import list',
            'create contact',
            'import contact',
            'manage list'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


        //Creazione ruolo ADMIN con tutti i permessi
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all()); 

        // Creazione ruolo EDITOR e assegno alcuni permessi
        $editorRole = Role::create(['name' => 'editor']);
        $editorRole->givePermissionTo([
            'write newsletter',
            'create list',
            //aggiungere
        ]);

        // Creazione ruolo ANALYST e assegno alcuni permessi
        $analystRole = Role::create(['name' => 'analyst']);
        $analystRole->givePermissionTo([
            'view analytics',
        ]);
    }
}
