<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmissionType extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'detail'];

    public function emissionSubTypes()
    {
        return $this->hasMany(EmissionSubType::class, 'emission_type_id');
    }
}
