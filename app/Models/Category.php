<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Product;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'image',
        'status',
        'slug',
    ];


    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function parent()
    {
        //if relation return null => using fun withDefault
        return $this->belongsTo(Category::class, 'parent_id', 'id')
            ->withDefault([
                'name' => '-'
            ]);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }


    //Local Scope
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }
    public function scopeFilter(Builder $builder, $filters)
    {
        if($filters['name'] ?? false)
        {
            $builder->where('categories.name', 'LIKE', "%{$filters['name']}%");
        }
        if($filters['status'] ?? false)
        {
            $builder->where('categories.status', '=', $filters['status']);
        }

    }

    // another solution to filter
    // public function scopeFilter(Builder $builder, $filters)
    // {

    //     $builder->when($filters['name'] ?? false, function($builder, $value) {
    //         $builder->where('categories.name', 'LIKE', "%{$value}%");
    //     });

    //     $builder->when($filters['status'] ?? false, function($builder, $value) {
    //         $builder->where('categories.status', '=', $value);
    //     });

    // }

   // Validation
    public static function rules($id = 0)
    {
        return [
            // 'name' => "required|string|min:3|max:225|unique:categories,name,$id",

            'name' => [
                'required',
                'string',
                'min:3',
                'max:225',
                Rule::unique('categories', 'name')->ignore($id),
            ],
            'parent_id' => [
                'nullable', 'int', 'exists:categories,id'
            ],
            'image' => [
                'image', 'max:1048576', 'dimensions:min_width=100,min_height=100',
            ],
            'status' => 'required|in:active,inactive',

        ];
    }
}
