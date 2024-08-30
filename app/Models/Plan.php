<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'plan_type_id', 'description', 'status'];

    public function planType()
    {
        return $this->belongsTo(PlanType::class);
    }

    public function tvOption()
    {
        return $this->hasOne(TvOption::class);
    }

    public function planOptions()
    {
        return $this->hasMany(PlanOption::class);
    }
}
