<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'product_category_id',
        'base_unit_code',
        'minimum_stock',
    ];

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'material_category_id');
    }

    public function baseUnit()
    {
        return $this->belongsTo(Unit::class, 'base_unit_code', 'code');
    }
}
