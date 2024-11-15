<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BasketProduct extends Pivot
{
    protected $guarded = ['id'];

    protected $table = 'basket_product';
    public $timestamps = false;
    protected $fillable = ['basket_id', 'product_id', 'sum', 'quantity', 'price'];
}
