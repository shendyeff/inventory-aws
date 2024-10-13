<?php

// app/Models/Order.php

namespace App\Models;

use App\Enums\OrderStatus; // Pastikan enum diimpor dengan benar
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasFactory;

    // Definisikan cast untuk kolom status
    protected $casts = [
        'status' => OrderStatus::class,
    ];

    protected $guarded = [];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Mengatur akses ke gambar
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($image) => asset('storage/orders/' . $image),
        );
    }

    // Daftar kolom yang dapat diisi
    protected $fillable = [
        'confirmation_code', 'name', 'quantity', 'status', 'image', 'unit', 'user_id', 'product_id',
    ];
}

