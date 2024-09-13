<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Link extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['label', 'url', 'type'];
    protected $translatable = ['label'];
}
