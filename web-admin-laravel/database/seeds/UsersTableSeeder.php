<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // admin user
        $adminUser = User::create([
            'name'  => 'Bilal Naeem',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@123')
        ]);
        $customerUser = User::create([
            'name'  => 'Bilal Naeem',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('customer@123')
        ]);
        $vendorUser = User::create([
            'name'  => 'Bilal Naeem',
            'email' => 'vendor@gmail.com',
            'password' => Hash::make('vendor@123')
        ]);
        $admin = Role::create([
          'name' => 'admin',
          'display_name' => 'Admin', // optional
          'description' => 'User is the admin of a given project', // optional
      ]);
        $customer = Role::create([
          'name' => 'customer',
          'display_name' => 'Customer', // optional
          'description' => 'User is the customer of a given project', // optional
      ]);
        $vendor = Role::create([
          'name' => 'vendor',
          'display_name' => 'vendor', // optional
          'description' => 'User is the vendor of a given project', // optional
      ]);
      $adminUser->attachRole('admin');
      $vendorUser->attachRole('vendor');
      $customerUser->attachRole('customer');
    }
}
