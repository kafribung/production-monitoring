<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function checkout_cart()
    {
        return $this->belongsTo(CheckoutCart::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
