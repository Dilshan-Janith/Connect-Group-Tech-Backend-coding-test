<?php

namespace App\Models\AppHumanResources\Attendance\Domain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PhpParser\Node\Expr\Cast\Double;

class Attendance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $hidden = [
        'employee', 'schedule'
    ];

    protected $appends = [
        'name', 'date', 'total_working_hours'
    ];

    public function schedule(): BelongsTo {
        return $this->belongsTo(Schedule::class);
    }

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class);
    }

    public function getNameAttribute(): string {
        return $this->employee->name;
    }

    public function getDateAttribute(): string {
        return $this->schedule->date;
    }

    public function getTotalWorkingHoursAttribute(): string {

        if ($this->time_in != null && $this->time_out != null) {

            $in_time = strtotime($this->time_in);
            $out_time = strtotime($this->time_out);

            $difference = abs($out_time - $in_time) / 3600;

            return $difference;

        } else {

            return 'N/A';
        }

    }
}
