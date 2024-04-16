<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'image',
        'status',
        'slug',
    ];

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