<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'product_name',
        'description',
        'code',
        'category_id',
        'supplier_id',
        'variant',
        'expiry',
        'unit_price',
        'unit_cost',
        'quantity',
        'total_cost',
    ];

}
