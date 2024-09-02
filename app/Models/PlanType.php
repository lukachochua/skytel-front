<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PlanType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description'];

    // Relationship with Plan
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
}
