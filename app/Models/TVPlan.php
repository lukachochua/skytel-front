<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TvPlan extends Model
{
    use HasFactory;

    protected $table = 'tv_plans';

    protected $fillable = ['name', 'description', 'price', 'plan_id'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class, 'tv_plan_id');
    }
}
