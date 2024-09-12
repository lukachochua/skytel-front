<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TeamMember extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['name', 'position', 'photo', 'description'];
    protected $translatable = ['name', 'position', 'description'];
}
