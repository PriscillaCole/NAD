<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use App\Models\LeaveData;

class DashboardController extends Controller
{
    //function to get the used leave days and remaining leave days per leave type for each user
    public static function getLeaveDays()
    {
        $userId = Admin::user()->id;
        $leaveDays = DB::table('employee_leave_credits')
            ->join('leave_types', 'employee_leave_credits.leave_type_id', '=', 'leave_types.id')
            ->select('employee_leave_credits.leave_type_id', 'leave_types.leave_type_name', 'employee_leave_credits.leave_days_used', 'employee_leave_credits.leave_days_remaining')
            ->where('employee_leave_credits.user_id', $userId)
            ->get();
            return view('dashboard.staff-dashboard.leave-days', compact('leaveDays'));
    }

    //function to get the monthly pattern of leave for a user
    public static function getMonthlyPattern()
    {
        $userId = Admin::user()->id;
        $monthlyPattern = DB::table('leave_data')
            ->select(DB::raw('MONTH(leave_data.date_of_leave) as month'))
            ->where('leave_data.approval_status', 'approved')
            ->get();
        
        return view('dashboard.staff-dashboard.monthly-pattern', compact('monthlyPattern'));
    }


    //show the calendar view
    public static function showCalendar()
    {
        try {
            // Fetch activities from the database
            $leaves = LeaveData::where('approval_status', 'approved')->get();
            
            // Transform activities into the required format for FullCalendar
            $accepted_requests = [];
            foreach ($leaves as $leave) {
                $accepted_requests[] = [
                    'title' => $leave->staff_id,
                    'start' => $leave->date_of_absence_from ,
                    'description' => $leave->description,
                    'number_of_days' => $leave->no_of_leave_days_requested, 
                ];
                }
            return view('calendar', compact('accepted_requests'));

        } catch (\Exception $e) {
            return ('Error fetching calendar events: ' . $e->getMessage());
        }
    }

    //get the types of leave available
    public static function getLeaveTypes()
    {
        $leaveTypes = DB::table('leave_types')
            ->get();
        return view('dashboard.staff-dashboard.leave-types', compact('leaveTypes'));
    }

    public function showWeeklyPattern(Request $request)
    {
        return self::getWeeklyPattern($request);
    }


    public static function getWeeklyPattern(?Request $request = null)
    {
        try {
            // Retrieve logged-in user's ID
            $userId = Admin::user()->id;
    
            // Retrieve selected month from request or default to current month
            $selectedMonth = $request ? $request->input('month', date('m')) : date('m');
    
            // Query to count leave requests by day of the week (Monday to Friday) for the selected month
            $weeklyPattern = DB::table('leave_data')
                ->select(DB::raw('DAYOFWEEK(leave_data.date_of_leave) as day_of_week, COUNT(*) as count'))
                ->where('leave_data.approval_status', 'approved')
                ->whereRaw('MONTH(leave_data.date_of_leave) = ?', [$selectedMonth])
                ->whereRaw('DAYOFWEEK(leave_data.date_of_leave) >= 2 AND DAYOFWEEK(leave_data.date_of_leave) <= 6') // Monday (2) to Friday (6)
                ->groupBy('day_of_week')
                ->orderBy('day_of_week')
                ->get();
    
            // Initialize arrays to store data for Chart.js
            $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            $counts = [0, 0, 0, 0, 0]; // Initialize counts for Monday to Friday
    
            // Fill counts array based on query results
            foreach ($weeklyPattern as $pattern) {
                $dayIndex = $pattern->day_of_week - 2; // Adjust index for zero-based array
                $counts[$dayIndex] = $pattern->count;
            }
            error_log($request);
            // Check if the request expects JSON response (e.g., AJAX request)
            if ($request && $request->expectsJson()) {
                // Return JSON response
                return response()->json([
                    'daysOfWeek' => $daysOfWeek,
                    'counts' => $counts,
                ]);
            } else {
                // Return view with the data
                return view('dashboard.staff-dashboard.weekly-pattern', [
                    'daysOfWeek' => $daysOfWeek,
                    'counts' => $counts,
                    'selectedMonth' => $selectedMonth,
                ]);
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            if ($request && $request->expectsJson()) {
                return response()->json(['error' => 'Error fetching weekly pattern: ' . $e->getMessage()], 500);
            } else {
                return 'Error fetching weekly pattern: ' . $e->getMessage();
            }
        }
    }
    
    


}