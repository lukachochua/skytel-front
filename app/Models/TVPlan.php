<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TvPlan extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'tv_plans';

    protected $fillable = ['name', 'description', 'price', 'plan_id'];
    protected $translatable = ['name', 'description'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
