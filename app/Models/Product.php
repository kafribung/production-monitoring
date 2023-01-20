<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function meterial()
    {
        return $this->belongsTo(ProductMaterial::class, 'product_material_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function colors()
    {
        return $this->belongsToMany(ProductColor::class, 'color_id');
    }

    public function sizes()
    {
        return $this->belongsToMany(ProductSize::class);
    }
}
