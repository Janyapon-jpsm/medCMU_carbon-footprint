<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReductionCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        're_id',
        're_sub_id',
        'amount',
        'month',
        'year',
        'total_cf'
    ];

    protected $table = 'reduction_calculations';
    protected $primaryKey = 're_cal_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reductionType()
    {
        return $this->belongsTo(ReductionType::class, 're_id');
    }

    public function reductionSubType()
    {
        return $this->belongsTo(ReductionSubType::class, 're_sub_id');
    }
}
