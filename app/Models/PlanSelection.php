<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanSelection extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'name',
        'phone',
        'tv_plan_id',
        'packages',
    ];

    protected $casts = [
        'packages' => 'array',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function tvPlan()
    {
        return $this->belongsTo(TvPlan::class);
    }
}
