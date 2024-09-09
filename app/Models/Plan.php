<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Plan extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['name', 'description', 'price', 'plan_type_id'];
    public $translatable = [];


    public function tvPlans()
    {
        return $this->hasMany(TvPlan::class, 'plan_id');
    }

    public function planType()
    {
        return $this->belongsTo(PlanType::class);
    }
}
