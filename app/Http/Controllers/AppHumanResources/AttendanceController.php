<?php

namespace App\Http\Controllers\AppHumanResources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\AppHumanResources\Attendance\UploadRequest;

use Inertia\Inertia;

use App\Services\AppHumanResources\Attendance\Application\AttendanceService;
use App\Services\AppHumanResources\Attendance\Application\GroupByOwnersService;

class AttendanceController extends Controller
{
    private AttendanceService $file_upload_service;
    private GroupByOwnersService $group_by_owners_service;
 
    public function __construct(AttendanceService $file_upload_service, GroupByOwnersService $group_by_owners_service)
    {
        $this->file_upload_service = $file_upload_service;
        $this->group_by_owners_service = $group_by_owners_service;
    }

    public function __invoke(UploadRequest $request)
    {
        // Call Attendance Service Invoke Method
        $this->file_upload_service->__invoke($request->validated());

        return response('Excel Upload Success', 200)->header('Content-Type', 'text/plain');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendance = $this->file_upload_service->index();

        return Inertia::render('Attendance/Index', [
            'attendance' => $attendance
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function findElementsOccurringMoreThanOnce() {

        // Original Array
        $a = [12, 10, 9, 45, 2, 10, 10, 45, 10, 9];

        // Multiple Occurring Element Array
        $o = [];

        // Original Array Count
        $n = count($a);

        for ($i = 0; $i < $n; $i++) {

            // Repeating Flag
            $repeating = false;

            for ($j = $i + 1; $j < $n; $j++) {

                if ($a[$i] === $a[$j]) {

                    if (!$repeating) {

                        if (!in_array($a[$i], $o)) {

                            array_push($o, $a[$i]);
                        }
                    }

                    $repeating = true;
                    break;
                }
            }
        }

        return $o;
    }

    public function groupByOwners() {
        
        return $this->group_by_owners_service->groupByOwners();
    }
}
