<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


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

    public function taxRate()
    {
        return $this->belongsTo(TaxRate::class, 'tax_rate_id');
    }

    public static function getTopSellingProducts($limit = 5)
    {
        return self::withCount(['transactions as sold_quantity' => function ($query) {
                    $query->select(DB::raw("SUM(quantity)"));
                }])
                ->orderByDesc('sold_quantity')
                ->take($limit)
                ->get();
    }

    public static function getTotalSalesPerProduct()
    {
        return DB::table('product_transaction')
            ->select('product_id', DB::raw('SUM(quantity * price_at_time) as total_sales'))
            ->groupBy('product_id')
            ->get();
    }

    public function getPriceIncludingtax()
    {
        if ($this->taxRate) {
            $taxPercentage = $this->taxRate->percentage; 
            return $this->price * (1 + $taxPercentage / 100);
        }
        return $this->price; 
    }

}