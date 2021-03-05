<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;


// Route::post("/user/login",[UserController::class, 'login']);
// Route::post("/app/user/login", 'UserController@login');
// Route::get("/app/user/logout", 'UserController@logout');


// dashboard
// Route::prefix('/app/dashboard')->middleware('auth')->group(function () {
//     Route::get('/get/summery', 'DashboardController@getSummeryData');
// });




// Route::group(['middleware' => ['auth', 'admin']], function () {
//     include_once 'admin/all.php';
// });

Route::prefix('/app/admin')->group(function () {
    include_once 'admin/all.php';
});

Route::post('/app/upload/file', 'UploadController@uploadFile');

Route::get('/', function () {
    return view('welcome');
});


// spa routes...
Route::any('{slug}', function () {
    return view('welcome');
})->where('slug', '([A-z\d\-\/_.]+)');