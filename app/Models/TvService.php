<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TvService extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['plan_id', 'name', 'price'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function tvServiceOptions()
    {
        return $this->hasMany(TvServiceOption::class);
    }
}
