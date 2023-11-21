<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tray extends Model
{
    use HasFactory;
    protected $table = 'customer_tray';
    protected $fillable = [
        'user_id',
        'product_id',
    ];
}
