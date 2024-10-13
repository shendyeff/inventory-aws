<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tambahkan beberapa data supplier contoh
        Supplier::create([
            'name' => 'PT. Sumber Pulsa',
            'telp' => '081234567890', // Pastikan ini 'telp'
            'address' => 'Jl. Raya Pulsa No. 1, Jakarta',
        ]);

        Supplier::create([
            'name' => 'PT. Data Provider',
            'telp' => '082345678901',
            'address' => 'Jl. Data No. 2, Jakarta',
        ]);

        Supplier::create([
            'name' => 'CV. Top Up Game',
            'telp' => '083456789012',
            'address' => 'Jl. Game No. 3, Jakarta',
        ]);

        Supplier::create([
            'name' => 'PT. Dompet Digital',
            'telp' => '084567890123',
            'address' => 'Jl. Digital No. 4, Jakarta',
        ]);

        Supplier::create([
            'name' => 'PT. PLN',
            'telp' => '085678901234',
            'address' => 'Jl. PLN No. 5, Jakarta',
        ]);
    }
}
