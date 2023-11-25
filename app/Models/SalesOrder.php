<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;
    protected $table = 'sales_order';
    public $timestamps = false;
    protected $fillable = [
        'transaction_number',
        'product_id',
        'user_id',
        'quantity',
        'price',
        'total_amount',
        'discount',
        'net_total',
        'sugar_content',
        'writing',
        'so_status',
        'so_note',
        'sales_date',
    ];
}
