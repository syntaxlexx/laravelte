<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();

        foreach($this->getDefaultUsers() as $user) {
            $exists = User::where('name', $user['name'])->first();

            if(! $exists) {
                $savedUser = User::create($user);
            }
        }
    }

    /**
     * get default users
     */
    public function getDefaultUsers() : array
    {
        return [
            [
                'name' => 'acelords',
                'email' => 'info@acelords.com',
                'password' => bcrypt('acelords'),
                'first_name' => 'AceLords',
                'last_name' => 'LTD',
                'status' => User::STATUS_ACTIVE,
                'role' => User::ROLE_SUPERADMIN
            ],
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
                'first_name' => 'Admin',
                'last_name' => 'Main',
                'status' => User::STATUS_ACTIVE,
                'role' => User::ROLE_ADMIN
            ],
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => bcrypt('user'),
                'first_name' => 'User',
                'last_name' => 'Customer',
                'status' => User::STATUS_ACTIVE,
                'role' => User::ROLE_USER
            ],
        ];
    }
}
