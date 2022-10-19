<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
* @mixin Builder
*/
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'image'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productsForGender($gender)
    {
        return Product::where('category_id', $this->id)->where('gender', $gender)->get();
    }
}
