<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function getTotalSales()
    {
        return self::sum('total');
    }

    public static function getTotalOrders()
    {
        return self::count();
    }

    public static function getSalesByMonth()
    {
        return self::selectRaw('MONTH(created_at) as month, SUM(total) as total')
                   ->groupBy('month')
                   ->get();
    }

    public static function getMonthlyProductSales()
    {
        return DB::table('product_transaction')
            ->join('transactions', 'transactions.id', '=', 'product_transaction.transaction_id')
            ->select(
                DB::raw('YEAR(transactions.created_at) as year'),
                DB::raw('MONTH(transactions.created_at) as month'),
                'product_transaction.product_id',
                DB::raw('SUM(product_transaction.quantity) as total_sold')
            )
            ->groupBy('year', 'month', 'product_transaction.product_id')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
    }

    public static function getMonthlyOrderCount()
    {
        return self::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(id) as order_count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
    }
}
