<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sales_invoice_number',
        'sales_order_id',
        'purchase_order_id',
        'payment_method',
        'status',
        'sales_total_amount',
        'paid_amount',
        'note',
    ];
}
