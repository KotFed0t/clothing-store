<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'name'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function upsertPropertyValues($values, $productId)
    {
        foreach ($values as $value){
            if($value != null){
                $data[] = ['product_id' => $productId, 'value_id' => $value];
            }
        }
        if (isset($data)){
            $this->upsert($data, ['product_id', 'value_id']);
        }
    }
}
