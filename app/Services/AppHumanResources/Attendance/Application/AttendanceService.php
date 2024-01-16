<?php

namespace App\Services\AppHumanResources\Attendance\Application;

use Maatwebsite\Excel\Facades\Excel;

use App\Imports\AttendanceImportClass;

use App\Models\AppHumanResources\Attendance\Domain\Attendance;

class AttendanceService {
 
    public function __invoke($request) {
 
        // Process the Excel file
        Excel::import(new AttendanceImportClass, $request['attendance']);
    }

    public function index() {

        return Attendance::all();
    }
}
