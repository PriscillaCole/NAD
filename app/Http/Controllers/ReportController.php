<?php

namespace App\Http\Controllers;
use App\Models\Activity;
use App\Models\Staff;
use App\Models\Requisition;

use Illuminate\Http\Request;

class ReportController extends Controller
{
   // In ReportController.php

   public function getActivities($projectId) {
    $activities = Activity::where('program_id', $projectId)->get();

    if ($activities->isEmpty()) {
        return response()->json(['activities' => [], 'message' => 'No activities found for the selected project.']);
    }

    return response()->json(['activities' => $activities]);
}


public function getStaff($activityId) {
    // Get staff who made requisitions under the selected activity
    $staff = Staff::whereHas('requisitions', function($query) use ($activityId) {
        $query->where('activity_id', $activityId);
    })->get();

    return response()->json(['staff' => $staff]);
}

public function getRequisitions($activityId) {
    $requisitions = Requisition::where('activity_id', $activityId)->get();

    if ($requisitions->isEmpty()) {
        return response()->json(['requisitions' => [], 'message' => 'No requisitions found for the selected activity.']);
    }

    return response()->json(['requisitions' => $requisitions]);
}

public function generateReport(Request $request)
{
    // Get form input data
    $projectId = $request->input('project_id');
    $activityId = $request->input('activity_id');
    $staffId = $request->input('staff_id');
    $status = $request->input('status');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Start building the query for requisitions
    $query = Requisition::query();

    // Apply project filter if selected
    if ($projectId) {
        $query->whereHas('activity.program', function ($q) use ($projectId) {
            $q->where('id', $projectId);
        });
    }

    // Apply activity filter if selected
    if ($activityId) {
        $query->where('activity_id', $activityId);
    }

    // Apply staff filter if selected
    if ($staffId) {
        $query->where('staff_id', $staffId);
    }

    // Apply status filter if selected
    if ($status) {
        $query->where('status', $status);
    }

    // Apply date range filter if selected
    if ($startDate && $endDate) {
        $query->whereBetween('updated_at', [$startDate, $endDate]);
    }

    // Get the filtered requisitions
    $requisitions = $query->get();
    //dd($requisitions);

    // Generate a report summary (or pass data to a view)
    return view('requisition_report', compact('requisitions'));
}

}
