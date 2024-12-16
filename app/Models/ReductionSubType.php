<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReductionSubType extends Model
{
    use HasFactory;

    protected $table = 'reduction_sub_types';

    protected $primaryKey = 're_sub_id';

    protected $fillable = ['sub_type', 'emission_factor', 'unit'];

    public function reductionType()
    {
        return $this->belongsTo(ReductionType::class, 're_id', 're_id');
    }
}
