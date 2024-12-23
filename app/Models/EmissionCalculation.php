<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmissionCalculation extends Model
{
    use HasFactory;

    protected $table = 'emission_calculations';

    protected $primaryKey = 'em_cal_id';

    protected $fillable = [
        'user_id',
        'em_id',
        'em_sub_id',
        'amount',
        'month',
        'year',
        'total_cf'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function emissionType()
    {
        return $this->belongsTo(EmissionType::class, 'em_id');
    }

    public function emissionSubType()
    {
        return $this->belongsTo(EmissionSubType::class, 'em_sub_id');
    }
}
