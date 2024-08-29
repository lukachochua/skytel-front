<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanOption extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('region_id', 'municipality_id', 'village_id', 'street_address', 'is_setanta', 'family_number')->withTimestamps();
    }
}
