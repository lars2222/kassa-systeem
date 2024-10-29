<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode',
        'name',
        'price',
        'description',
        'category_id',
        'tax_rate_id',
        'btw_type',
        'image',
    ];

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class)
                    ->withPivot('quantity', 'price_at_time', 'total');
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'product_discount');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }
}