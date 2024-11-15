<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['status' => OrderStatus::class];
    }
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
            ->withPivot(['quantity','sum','price']);
    }

    public function paymentType(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

}
