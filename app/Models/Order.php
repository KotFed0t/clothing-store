<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @mixin Builder
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'user_id',
        'country',
        'city',
        'address',
        'postal_code'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('count', 'size_id')->withTimestamps();
    }

    public function getFullPrice()
    {
        $sum = 0;
        foreach ($this->products as $product) {
            $sum += $product->getPriceForCount();
        }
        return $sum;
    }

    public function getStatusName() {
        return Status::where('id', $this->status)->first()->name;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
