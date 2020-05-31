<?php

use App\ApiRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class ApiRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat izin
        Permission::create(['name' => 'create a document', 'guard_name' => 'api']);
        Permission::create(['name' => 'read a document', 'guard_name' => 'api']);
        Permission::create(['name' => 'read documents', 'guard_name' => 'api']);
        Permission::create(['name' => 'update a document', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete a document', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete documents', 'guard_name' => 'api']);
        Permission::create(['name' => 'confirm a returned document', 'guard_name' => 'api']);
        Permission::create(['name' => 'confirm returned documents', 'guard_name' => 'api']);
        Permission::create(['name' => 'borrow a document', 'guard_name' => 'api']);
        Permission::create(['name' => 'borrow documents', 'guard_name' => 'api']);
        Permission::create(['name' => 'return a document', 'guard_name' => 'api']);
        Permission::create(['name' => 'return documents', 'guard_name' => 'api']);
        Permission::create(['name' => 'read users', 'guard_name' => 'api']);
        Permission::create(['name' => 'read a user', 'guard_name' => 'api']);

        // Buat role dosen
        ApiRole::create(['name' => 'lecturer'])->givePermissionTo([
            'create a document',
            'read a document',
            'read documents',
            'update a document',
            'delete a document',
            'delete documents',
            'borrow a document',
            'borrow documents',
            'confirm a returned document',
            'confirm returned documents',
            'read users',
            'read a user'
        ]);

        // Buat role mahasiswa/i
        ApiRole::create(['name' => 'student'])->givePermissionTo([
            'read documents',
            'borrow a document',
            'borrow documents',
            'return a document',
            'return documents'
        ]);

        // Buat role root
        ApiRole::create(['name' => 'root'])->givePermissionTo(Permission::all());
    }
}
