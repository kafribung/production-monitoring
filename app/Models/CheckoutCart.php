<?php

namespace App\Models;

use App\Models\Trait\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckoutCart extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CreatedUpdatedBy;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function cartProduct()
    {
        return $this->hasOneThrough(
            Product::class,
            Cart::class,
            'product_id',
            'id',
            'cart_id',
            'id',
        );
    }
}
