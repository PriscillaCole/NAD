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
        $programId2 = request()->query('programId2');
        $data = DashboardController::getBudgetComparisonData($programId2);
    
        return $content
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->append(DashboardController::getRequisitionStatus());
                });
            })
            ->row(function (Row $row) use ($programId) {
                $row->column(6, function (Column $column) use ($programId) {
                    // Pass the programId to the getActivityRequisitionData function
                    $column->append(DashboardController::getActivityRequisitionData($programId));
                });
                $row->column(6, function (Column $column) {
                    $column->append(DashboardController::showProgramsWithActivities());
                });
            })
            ->row(function (Row $row) use ($data) {
                $row->column(6, function (Column $column) use ($data) {
                    $column->append(view('dashboard.budget_comparison_chart', $data));
                });
            });
    }
    
}
