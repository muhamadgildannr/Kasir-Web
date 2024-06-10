<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogStock extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "product_id",
        "total_stock",
        "description",
        "status",
    ];

    public function product()
    {
        return $this->belongsTo(Produk::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
