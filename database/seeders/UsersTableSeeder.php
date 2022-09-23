<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        User::create([
            'name' => 'Hector Admin',
            'email' => 'hectoradmin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'), // password
            'cedula' => '3800700',
            'address' => 'San Lorenzo - Paraguay',
            'phone' => '0961333666',
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Hector Paciente',
            'email' => 'hectorpaciente@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'), // password
            'cedula' => '3800701',
            'address' => 'San Lorenzo - Paraguay1',
            'phone' => '0961333668',
            'role' => 'paciente'
        ]);
        User::create([
            'name' => 'Hector Medico',
            'email' => 'hectormedico@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'), // password
            'cedula' => '3800702',
            'address' => 'San Lorenzo - Paraguay2',
            'phone' => '0961333667',
            'role' => 'doctor'
        ]);

        User::factory()
            ->count(50)
            ->state(['role' => 'paciente'])
            ->create();
    }
}
