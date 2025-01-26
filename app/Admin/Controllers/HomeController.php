<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use App\Http\Controllers\DashboardController;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        // Fetch the programId from the request (this assumes you're passing it via query string, i.e., ?programId=1)
        $programId = request()->query('programId');
        // Fetch data for the chart
        $year = request()->query('year');
        $programId2 = request()->query('programId2');
        $data = DashboardController::programBudget($programId2);
        $fund = DashboardController::yearExpense($year);
        $status = DashboardController::RequisitionStatuschart();

        $period = request()->query('period', 'month'); // Default to 'month' if not specified
        $chartData = DashboardController::getAverageApprovalTimeData($period);
    
        return $content
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->append(DashboardController::getRequisitionStatus());
                });
            })
            ->row(function (Row $row) use ($data, $status) {
                $row->column(12, function (Column $column) use ($status) {
                    // Pass the programId to the getActivityRequisitionData function
                    $column->append(view('dashboard.fund_request_status_overview', $status));
                });
                
               
            })
            ->row(function (Row $row) use ($programId, $data, $fund) {
                $row->column(12, function (Column $column) use ($data, $fund) {
                        $column->append(view('dashboard.fund_disbursement_summary', $data, $fund));
                    });
                // $row->column(6, function (Column $column) use ($fund) {
                //     $column->append(view('dashboard.funds_over_time', $fund));
                // });
                
                
            })
            ->row(function (Row $row) use ($data, $chartData) {
                $row->column(12, function (Column $column) {
                    $column->append(DashboardController::showProgramsWithActivities());
                });
                
            })
            ->row(function (Row $row) use ($data, $programId2) {
                $row->column(12, function (Column $column) use ($programId2) {
                    $column->append(DashboardController::getBudgetComparisonData($programId2));
                });
        
            
            });
    }

    private function getHeatmapColor($value) {
        // Convert value to a color on a scale from yellow to green
        $hue = 60 + ($value * 60); // 60 is yellow, 120 is green
        return "hsl($hue, 75%, 60%)";
    }
    
}
