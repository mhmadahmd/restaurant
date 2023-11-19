<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    // use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'admin_rest_id'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function discount()
    {
        return $this->morphOne(Discount::class, 'discountable');
    }
}
