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
        DB::transaction(function () {
            // Buat user admin
            DB::table('users')->insert([
                'name' => 'Super User',
                'email' => 'root@localhost',
                'password' => Hash::make('root')
            ]);

            $getUserIdByEmail = fn (string $email) => DB::table('users')->where('email', $email)->first()->id;

            DB::table('user_profiles')->insert([
                'user_id' => $getUserIdByEmail('root@localhost'),
                'registration_number' => '1',
                'phone_number' => 'X',
                'address' => 'X',
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

            DB::table('user_profiles')->insert([
                'user_id' => $getUserIdByEmail('lecturer@localhost'),
                'registration_number' => '1',
                'phone_number' => 'Y',
                'address' => 'Y',
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

            DB::table('user_profiles')->insert([
                'user_id' => $getUserIdByEmail('student@localhost'),
                'registration_number' => '1',
                'phone_number' => 'Z',
                'address' => 'Z',
            ]);

            // Tambah role untuk mahasiswa
            $lecturerRole = Role::findByName('student', 'api');
            User::where('email', 'student@localhost')->first()->assignRole($lecturerRole);
        });
    }
}
