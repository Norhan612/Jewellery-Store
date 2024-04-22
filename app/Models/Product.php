<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\Scopes\StoreScope;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    // Make Global Scope 
    // and it apply automatically in ProductsController
    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());
    } 
}
