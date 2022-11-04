<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Config;

/**
 * @mixin Builder
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'image',
        'price',
        'category_id',
        'gender'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceForCount()
    {
        if (!is_null($this->pivot)) {
            return $this->pivot->count * $this->price;
        }
        return $this->price;
    }

    public function values()
    {
        return $this->belongsToMany(Value::class);
    }

    public function images()
    {
        $rows = DB::table('image_product')->where('product_id', $this->id)->select('image')->get();
        $images = [];
        foreach ($rows as $row) {
            $images[] = $row->image;
        }
        return $images;
    }
}
