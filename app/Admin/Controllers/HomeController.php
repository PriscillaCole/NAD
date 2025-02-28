<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use App\Http\Controllers\DashboardController;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Controllers\AdminController;


class HomeController extends AdminController
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
        // $chartData = DashboardController::getAverageApprovalTimeData($period);
    
        return $content
        
            ->title('Dashboard') // Set the title here
            ->description('Track budgets, expenses, and requisitions') 
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
            ->row(function (Row $row) use ($data) {
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

    
    
}
