<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Mendapatkan role yang dibutuhkan
        $roleAdmin = Role::where('name', 'Super Admin')->first();
        $roleCustomer = Role::where('name', 'Customer')->first();

        // Seeder untuk Super Admin
        $admin = User::updateOrCreate(
            ['email' => 'sinmaofficial@gmail.com'],  // Kondisi pencarian
            [
                'name' => 'Super Admin',
                'password' => bcrypt('12345678'),
                'phone_number' => '089514851100',
                'address' => 'Jl. Yos Sudarso No. 114 Madiun',
            ]
        );

        // Assign peran jika belum terassign
        if (!$admin->hasRole($roleAdmin)) {
            $admin->assignRole($roleAdmin);
        }

        // Seeder untuk Customer 1
        $customer1 = User::updateOrCreate(
            ['email' => 'shendi@gmail.com'],
            [
                'name' => 'Shendi Teuku',
                'password' => bcrypt('12345678'),
                'phone_number' => '08567891234',
                'address' => 'Jl. Merak No. 121, Surabaya',
            ]
        );

        // Assign role Customer
        if (!$customer1->hasRole($roleCustomer)) {
            $customer1->assignRole($roleCustomer);
        }

        // Seeder untuk Customer 2
        $customer2 = User::updateOrCreate(
            ['email' => 'andre@testing.com'],
            [
                'name' => 'Andre Wibowo',
                'password' => bcrypt('12345678'),
                'phone_number' => '08765432101',
                'address' => 'Jl. Raya Bogor No. 45, Depok',
            ]
        );

        // Assign role Customer
        if (!$customer2->hasRole($roleCustomer)) {
            $customer2->assignRole($roleCustomer);
        }

        // Seeder untuk Customer 3
        $customer3 = User::updateOrCreate(
            ['email' => 'sari@sample.com'],
            [
                'name' => 'Sari Melati',
                'password' => bcrypt('12345678'),
                'phone_number' => '08213344556',
                'address' => 'Jl. Pahlawan No. 78, Bandung',
            ]
        );

        // Assign role Customer
        if (!$customer3->hasRole($roleCustomer)) {
            $customer3->assignRole($roleCustomer);
        }

        // Seeder untuk Customer 4
        $customer4 = User::updateOrCreate(
            ['email' => 'eko@demo.com'],
            [
                'name' => 'Eko Prasetyo',
                'password' => bcrypt('12345678'),
                'phone_number' => '08987654321',
                'address' => 'Jl. Raya Semarang No. 89, Semarang',
            ]
        );

        // Assign role Customer
        if (!$customer4->hasRole($roleCustomer)) {
            $customer4->assignRole($roleCustomer);
        }

        // Seeder untuk Customer 5
        $customer5 = User::updateOrCreate(
            ['email' => 'lina@testing.com'],
            [
                'name' => 'Lina Amelia',
                'password' => bcrypt('12345678'),
                'phone_number' => '08543219876',
                'address' => 'Jl. Bunga No. 56, Yogyakarta',
            ]
        );

        // Assign role Customer
        if (!$customer5->hasRole($roleCustomer)) {
            $customer5->assignRole($roleCustomer);
        }
    }
}
