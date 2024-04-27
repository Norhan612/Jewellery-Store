<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\Scopes\StoreScope;
use App\Models\Category;
use App\Models\Store;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'name', 'slug', 'description', 'image', 'category_id', 'store_id',
        'price', 'compare_price', 'status',
    ];

    // Make Global Scope 
    // and it apply automatically in ProductsController
    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());
    } 

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
}
