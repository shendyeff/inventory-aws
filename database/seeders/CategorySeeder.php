<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Daftar kategori
        $categories = [
            ['name' => 'Pulsa', 'image' => 'default-pulsa.png'], // Ganti dengan nama file gambar yang sesuai
            ['name' => 'Paket Data', 'image' => 'default-paket-data.png'], // Ganti dengan nama file gambar yang sesuai
            ['name' => 'Top Up Game', 'image' => 'default-top-up-game.png'], // Ganti dengan nama file gambar yang sesuai
            ['name' => 'Dompet Digital', 'image' => 'default-dompet-digital.png'], // Ganti dengan nama file gambar yang sesuai
            ['name' => 'PLN', 'image' => 'default-pln.png'], // Ganti dengan nama file gambar yang sesuai
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                ['image' => $category['image']]
            );
        }
    }
}