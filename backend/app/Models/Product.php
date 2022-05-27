<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'name', 'price', 'qty'];

    public function getTotalPrice(int $qty = 1): float
    {
        /* 
            In a future we would check for discounts for purchasing multiple products at time
            and get taxes by country and apply it to price, and combinations, etc. A lot of variables but, by now,
            we only make a simple product
        */

        return $this->price * $qty;
    }
}
