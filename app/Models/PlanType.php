<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PlanType extends Model
{
    use HasFactory;
    use HasTranslations;
    
    protected $fillable = ['name'];
    protected $translatable = ['name'];

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
}
