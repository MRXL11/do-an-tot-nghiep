<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['attribute_id', 'value'];

    /**
     * Lấy thuộc tính cha của giá trị này.
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}