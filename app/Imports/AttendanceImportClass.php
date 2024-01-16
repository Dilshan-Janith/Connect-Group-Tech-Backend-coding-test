<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use App\Models\AppHumanResources\Attendance\Domain\Location;
use App\Models\AppHumanResources\Attendance\Domain\Employee;
use App\Models\AppHumanResources\Attendance\Domain\Shift;
use App\Models\AppHumanResources\Attendance\Domain\Schedule;
use App\Models\AppHumanResources\Attendance\Domain\Attendance;

class AttendanceImportClass implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        // Add Location To DB
        if (!Location::whereCode($collection[4][1])->exists()) {

            // Save Location
            $location = new Location;
            $location->name = $collection[3][1];
            $location->code = $collection[4][1];
            $location->save();
        }

        // Add Employee To DB
        if (!Employee::whereEmail($collection[2][1])->exists()) {

            // Save Employee
            $employee = new Employee;
            $employee->name = $collection[0][1];
            $employee->email = $collection[2][1];
            $employee->position = $collection[1][1];
            $employee->save();

        } else {

            // Update Employee
            $employee = Employee::whereEmail($collection[2][1])->first();
            $employee->name = $collection[0][1];
            $employee->email = $collection[2][1];
            $employee->position = $collection[1][1];
            $employee->save();
        }

        // Shift Array
        $shift_array = [];

        // Add Shift To DB
        foreach ($collection[6] as $key => $value) {

            if ($key != 0 && $value != null) {

                if (!Shift::whereName($value)->exists()) {

                    // Save Shift
                    $shift = new Shift;
                    $shift->name = $value;
                    $shift->save();

                    array_push($shift_array, $shift);

                } else {

                    // Update Shift
                    $shift = Shift::whereName($value)->first();
                    $shift->name = $value;
                    $shift->save();
                }
            }
        }

        // Add Schedule To DB
        foreach ($collection[9] as $key => $date) {

            if ($key != 0 && $date != null) {

                if (!Schedule::where('date', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d'))->exists()) {

                    // Save Schedule
                    $schedule = new Schedule;
                    $schedule->date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');

                    if ($schedule->save()) {

                        // Add Attendance To DB
                        if ($key != 0 || $date != null) {

                            // Save Attendance
                            $attendance = new Attendance;
                            $attendance->employee_id = $employee->id;
                            $attendance->schedule_id = $schedule->id;
                            $attendance->time_in = $collection[12][$key] != null ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($collection[12][$key])->format('H:i:s') : null;
                            $attendance->time_out = $collection[13][$key] != null ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($collection[13][$key])->format('H:i:s') : null;
                            $attendance->save();
                        }
                        
                        // Attach Schedule Locations
                        if (isset($location)) {

                            $schedule->location()->attach($location->id);
                        }

                        // Attach Schedule Employees
                        if (isset($employee)) {

                            $schedule->employee()->attach($employee->id);
                        }

                        foreach ($shift_array as $key => $shift) {

                            // Attach Schedule Shifts
                            if (isset($shift)) {

                                $schedule->shift()->attach($shift->id);
                            }
                        }
                    }

                } else {

                    // Update Schedule
                    $schedule = Schedule::where('date', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d'))->first();
                    $schedule->date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
                    $schedule->save();
                }
            }
        }
    }
}
