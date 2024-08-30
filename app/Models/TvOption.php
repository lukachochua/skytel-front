<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TvOption extends Model
{
    use SoftDeletes;

    protected $fillable = ['plan_id', 'setanta'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
