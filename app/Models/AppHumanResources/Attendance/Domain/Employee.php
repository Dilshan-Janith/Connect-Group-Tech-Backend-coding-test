<?php

namespace App\Models\AppHumanResources\Attendance\Domain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function schedule(): BelongsToMany {
        return $this->belongsToMany(Schedule::class);
    }

    public function attendance(): hasMany {
        return $this->hasMany(Attendance::class)->withTimestamps();
    }
}
