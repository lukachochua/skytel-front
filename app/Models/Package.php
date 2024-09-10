<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Package extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['name', 'description', 'price', 'tv_plan_id'];
    protected $translatable = ['name', 'description'];

    public function tvPlan()
    {
        return $this->belongsTo(TvPlan::class);
    }
}
