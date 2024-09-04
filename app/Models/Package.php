<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['tv_plan_id', 'name', 'price'];

    public function tvPlan()
    {
        return $this->belongsTo(TVPlan::class);
    }
}
