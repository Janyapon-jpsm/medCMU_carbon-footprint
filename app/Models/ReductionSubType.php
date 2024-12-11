<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReductionSubType extends Model
{
    use HasFactory;

    protected $fillable = ['sub_type', 'emission_factor', 'unit'];
}
