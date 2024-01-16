<?php

namespace App\Models\AppHumanResources\Attendance\Domain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function location(): BelongsToMany {
        return $this->belongsToMany(Location::class)->withTimestamps();
    }

    public function employee(): BelongsToMany {
        return $this->belongsToMany(Employee::class)->withTimestamps();
    }

    public function shift(): BelongsToMany {
        return $this->belongsToMany(Shift::class)->withTimestamps();
    }

    public function attendance(): hasOne {
        return $this->hasOne(Attendance::class)->withTimestamps();
    }
}
