<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRole = Role::where('name', 'USER')->first();
        $approverRole = Role::where('name', 'APPROVER')->first();

        User::create([
            'name' => 'Aravind Kumar',
            'email' => 'aravind@example.com',
            'password' => Hash::make('password'),
            'role_id' => $approverRole->id
        ]);

        User::create([
            'name' => 'Anand Reddy',
            'email' => 'anand@example.com',
            'password' => Hash::make('password'),
            'role_id' => $approverRole->id
        ]);

        User::create([
            'name' => 'Ram Mohan',
            'email' => 'ram@example.com',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id
        ]);

        User::create([
            'name' => 'Srikanth Yadav',
            'email' => 'srikanth@example.com',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id
        ]);

        User::create([
            'name' => 'Srujan Reddy',
            'email' => 'srujan@example.com',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id
        ]);

        User::create([
            'name' => 'Mahendar Verma',
            'email' => 'mahendar@example.com',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id
        ]);
    }
}
