<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReductionType extends Model
{
    use HasFactory;

    protected $table = 'reduction_types';

    protected $primaryKey = 're_id';

    protected $fillable = ['type', 'detail'];

    public function reductionSubTypes()
    {
        return $this->hasMany(ReductionSubType::class, 're_id', 're_id');
    }
}
