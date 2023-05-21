<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();
        // static::creating(function ($question) {
        //     $question->slug = Str::slug($question->title);
        // });
    }

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function materil()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'product_id');
    }

    public function oldestImage()
    {
        return $this->hasOne(Image::class, 'product_id')->oldestOfMany();
    }

    public function carts()
    {
        return  $this->hasMany(Cart::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }

    public function customs()
    {
        return $this->belongsToMany(Custom::class);
    }
}
