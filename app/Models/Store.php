<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Store extends Model
{
    use HasFactory, Notifiable;
    
    protected $table = 'stores';

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id', 'id');
    }
}
