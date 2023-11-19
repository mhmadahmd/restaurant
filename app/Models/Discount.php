<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    // use HasFactory;
    protected $fillable = ['amount', 'discountable_id', 'discountable_type'];

    public function discountable()
    {
        return $this->morphTo();
    }
}
