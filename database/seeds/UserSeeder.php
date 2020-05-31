<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat user admin
        DB::table('users')->insert([
            'name' => 'Super User',
            'email' => 'root@localhost',
            'password' => Hash::make('root')
        ]);

        // Tambah role untuk admin
        $rootRole = Role::findByName('root', 'api');
        User::where('email', 'root@localhost')->first()->assignRole($rootRole);

        // Buat user dosen
        DB::table('users')->insert([
            'name' => 'Lecturer',
            'email' => 'lecturer@localhost',
            'password' => Hash::make('lecturer')
        ]);

        // Tambah role untuk dosen
        $lecturerRole = Role::findByName('lecturer', 'api');
        User::where('email', 'lecturer@localhost')->first()->assignRole($lecturerRole);

        // Buat user mahasiswa
        DB::table('users')->insert([
            'name' => 'Student',
            'email' => 'student@localhost',
            'password' => Hash::make('student')
        ]);

        // Tambah role untuk mahasiswa
        $lecturerRole = Role::findByName('student', 'api');
        User::where('email', 'student@localhost')->first()->assignRole($lecturerRole);
    }
}
