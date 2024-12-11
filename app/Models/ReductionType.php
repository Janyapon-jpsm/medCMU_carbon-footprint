<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReductionType extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'detail'];

    public function reductionSubTypes()
    {
        return $this->hasMany(ReductionSubType::class, 'reduction_type_id');
    }
}
