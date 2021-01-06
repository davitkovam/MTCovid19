<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\NijzArrayController;
use App\Http\Controllers\PopulationController;
use App\Http\Controllers\SvetController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/pop/{reg}', [PopulationController::class, 'regija']);
Route::get('/svet', [SvetController::class, 'getTable']);


/*
Route::get('/showArray', function () {
    $seznam = EntryController::getDictionary();
    echo NijzArrayController::getCasesOnDateInRegion($seznam, '2020-03-22', "Savinjska");
    //return view('all', ['seznam' => $seznam]);
});
*/
Route::get('/showArray', function () {
    $seznam = EntryController::getDictionary();
    echo NijzArrayController::getCasesUntilDateInRegion($seznam, '2020-03-22', "Savinjska");
    //return view('all', ['seznam' => $seznam]);
});