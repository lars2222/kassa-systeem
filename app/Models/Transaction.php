<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subtotal',
        'total',
        'tax',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_transaction')
                    ->withPivot('quantity', 'price_at_time', 'total', 'discount_applied')
                    ->withTimestamps();
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
