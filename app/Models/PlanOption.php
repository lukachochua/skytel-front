<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanOption extends Model
{
    use SoftDeletes;

    protected $fillable = ['plan_id', 'option_name', 'price'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
