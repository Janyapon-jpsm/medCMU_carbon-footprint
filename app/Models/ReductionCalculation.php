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
        'year'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reductionType()
    {
        return $this->belongsTo(ReductionType::class, 're_id');
    }
}
