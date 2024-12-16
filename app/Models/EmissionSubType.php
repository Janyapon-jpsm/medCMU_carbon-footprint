<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmissionSubType extends Model
{
    use HasFactory;

    protected $table = 'emission_sub_types';

    protected $primaryKey = 'em_sub_id';

    protected $fillable = ['sub_type', 'emission_factor', 'unit'];

    public function emissionType()
    {
        return $this->belongsTo(EmissionType::class, 'em_id', 'em_id');
    }
}
