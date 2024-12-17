<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmissionCalculation extends Model
{
    use HasFactory;

    protected $table = 'emission_calculation';

    protected $primaryKey = 'em_cal_id';

    protected $fillable = [
        'em_sub_id',
        'user_id',
        'unit',
        'amount',
        'month',
        'year'
    ];
}
