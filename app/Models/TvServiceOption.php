<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TvServiceOption extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['tv_service_id', 'option_name', 'enabled', 'additional_price'];

    public function tvService()
    {
        return $this->belongsTo(TvService::class);
    }
}
