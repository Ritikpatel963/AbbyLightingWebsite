<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecorativeProductSpecSection extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(DecorativeProduct::class, 'decorative_product_id');
    }

    public function specifications()
    {
        return $this->hasMany(DecorativeProductSpecification::class, 'section_id');
    }
}
