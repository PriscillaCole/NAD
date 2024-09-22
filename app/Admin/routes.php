<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/dashboard', 'HomeController@index')->name('home');
    $router->resource('staff', StaffController::class);
    $router->resource('accountabilities', AccountabilityController::class);
    $router->resource('budgets', BudgetController::class);
    $router->resource('requisitions', RequisitionController::class);
    $router->resource('programs', ProgramController::class);
    $router->resource('activities', ActivityController::class);
    $router->resource('categories', CategoryController::class);
    $router->resource('reports', ReportController::class);

   

});
