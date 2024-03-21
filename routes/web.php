<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PhotocopyController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\StudentPageController;
use App\Http\Controllers\MoneyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentListController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\PaymentServicesController;
use App\Http\Controllers\SearchStudentController;
use App\Http\Controllers\SearchAddMoneyController;
use App\Http\Controllers\SearchDeptController;
use App\Http\Controllers\SearchPayServiceController;
use App\Http\Controllers\GenerateReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TrackRecordController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\WeatherController;
use App\Http\Resources\UserResource;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['namespace' => 'App\Http\Controllers'], function () {
    /**
     * Home Routes
     */
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    Route::group(['middleware' => ['guest']], function () {
        /**
         * Register Routes
         */
        // Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
        // Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');


        /**
         * Login Routes
         */
        Route::get('/login', [LoginController::class, 'show'])->name('login.show');
        Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
    });

    Route::group(['middleware' => ['auth']], function () {
        /**
         * Logout Routes
         */
        Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');

        /**
         * Student Routes
         */
        Route::get('/students/create', [StudentPageController::class, 'create'])->name('students.create');
        Route::post('/students/store', [StudentPageController::class, 'store'])->name('students.store');


        Route::get('/students/edit/{id}', [StudentListController::class, 'edit'])->name('students.edit');
        Route::put('/students/update/{id}', [StudentListController::class, 'update'])->name('students.update');
        Route::delete('/students/delete/{id}', [StudentListController::class, 'destroy'])->name('students.delete');


        /**
         * Money Routes
         */

        Route::get('/money/add', [MoneyController::class, 'showForm'])->name('money.add.form');
        Route::post('/money/add', [MoneyController::class, 'addMoney'])->name('money.add');



        /**
         * Student list Routes
         */
        Route::get('/student-list', [StudentListController::class, 'studentlist'])->name('students.studentlist');


        /**
         * Services Routes
         */
        Route::get('/services/list', [ServicesController::class, 'index'])->name('services.list');

        Route::get('/services', [ServicesController::class, 'index'])->name('services.index');
        Route::get('/services/create', [ServicesController::class, 'create'])->name('services.create');
        Route::post('/services', [ServicesController::class, 'store'])->name('services.store');

        Route::get('/services/{service}/edit', [ServicesController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [ServicesController::class, 'update'])->name('services.update');
        Route::delete('/services/delete/{service}', [ServicesController::class, 'destroy'])->name('services.delete');










        // Display the payment form
        Route::get('/payforservices/pay', [PaymentServicesController::class, 'showPaymentForm'])->name('payforservices.pay');

        // Process the payment
        Route::post('/payforservices/process-payment', [PaymentServicesController::class, 'processPayment'])->name('payforservices.process-payment');

        // Search
        Route::post('/search-student', [PaymentServicesController::class, 'searchStudent'])->name('search.student');



        Route::get('/search-student', [SearchStudentController::class, 'search'])->name('search-student');




        // searchadd money  routes...

        // Route::get('/searchaddmoney', [SearchAddMoneyController::class, 'searchStudent'])->name('searchaddmoney.search');
        // Route::post('/searchmoney/execute', [SearchAddMoneyController::class, 'addMoney'])->name('searchmoney.execute');


        Route::get('/searchaddmoney', [SearchAddMoneyController::class, 'searchStudent'])->name('searchaddmoney.search');
        Route::post('/searchaddmoney', [SearchAddMoneyController::class, 'searchaddMoney'])->name('searchmoney.execute');







        // 25.01.2024



        Route::post('/search/students', [PaymentServicesController::class, 'showPaymentForm'])->name('search.students');

        //29-01-2024

        Route::get('/searchpayservice', [SearchPayServiceController::class, 'searchStudent'])->name('searchpayservice.search');
        Route::post('/searchpayservice', [SearchPayServiceController::class, 'searchPayService'])->name('searchservice.execute');

        //for updating the balance after the pay for services
        Route::post('/update-balance/{studentId}/{amount}', [SearchPayServiceController::class, 'updateBalance'])->name('update-balance');


        // transaction history completed 31-01-2024

        Route::post('/save-transaction', [SearchPayServiceController::class, 'saveTransaction']);


        //report 05-02-2024

        // Route::get('/generate-report', [GenerateReportController::class, 'generateReport'])->name('generatereport');


        // Route::get('export-excel', [GenerateReportController::class, 'exportToExcel'])->name('export.excel');

        // Route::get('export-csv', [GenerateReportController::class, 'exportToCsv'])->name('export.csv');

        // Route::get('export-pdf', [GenerateReportController::class, 'exportToPDF'])->name('export.pdf');

        //Route::get('/generate-report', [GenerateReportController::class, 'generate'])->name('generate.report');


        //18-02-2024

        // Route::post('/export-report', [GenerateReportController::class, 'export'])->name('export-report');


        // Route::get('/export/excel', [GenerateReportController::class, 'export'])->name('export.excel');
        // Route::get('/export/csv', [GenerateReportController::class, 'exportToCSV'])->name('export.csv');
        // Route::get('/export/pdf', [GenerateReportController::class, 'exportToPDF'])->name('export.pdf');



        // 18-02-2024

        // Route::get('/generate-report', [ReportController::class, 'report'])->name('generatereport');


        Route::get('/reports/generate-report', [ReportController::class, 'showReportGenerationForm'])->name('generatereport');

        Route::post('/reports/export/selected-students', [ReportController::class, 'exportSelectedStudents'])->name('export-selected-students');



        Route::get('/export-selected-students-csv', [ReportController::class, 'exportSelectedStudentsCsv'])->name('export-selected-students-csv');
        Route::get('/export-selected-students-pdf', [ReportController::class, 'exportSelectedStudentsPdf'])->name('export-selected-students-pdf');


        //Tracking Records




        Route::get('/trackrecord', [TrackRecordController::class, 'index'])->name('trackrecord.index');
        Route::get('/trackrecord/search', [TrackRecordController::class, 'search'])->name('trackrecord.search');


        Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
        Route::get('/weather', [WeatherController::class, 'getWeather']);
    });
});
