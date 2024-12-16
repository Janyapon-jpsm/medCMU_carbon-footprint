<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmissionType extends Model
{
    use HasFactory;

    protected $table = 'emission_types';

    protected $primaryKey = 'em_id';

    protected $fillable = ['type', 'detail'];

    public function emissionSubTypes()
    {
        return $this->hasMany(EmissionSubType::class, 'em_id', 'em_id');
    }
}
