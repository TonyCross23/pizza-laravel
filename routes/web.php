<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Rules\Role;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
       if(Auth::check()) {
           if(Auth::user()->role == 'admin') {
               return redirect()->route('admin#profile');
           }else if(Auth::user()->role == 'user'){
                return redirect()->route('user#index');
           }
       }
    })->name('dashboard');
});

Route::group(['perfix' => 'admin','namespace'=>'Admin'],function(){
    // Route::get('admin','AdminController@index')->name('admin#index');
    Route::get('profile','CategoryController@profile')->name('admin#profile');
    Route::get('category','CategoryController@category')->name('admin#category'); // return list
    Route::get('addCategory','CategoryController@addCategory')->name('admin#addCategory');
    Route::post('createCategory','CategoryController@createCategory')->name('admin#createCategory');
    Route::get('deleteCategory/{id}', 'CategoryController@deleteCategory')->name('admin#deleteCategory');
    Route::get('editCategory/{id}','CategoryController@editCategory')->name('admin#editCategory');
    Route::post('updateCategory','CategoryController@updateCategory')->name('admin#updateCategory');
    Route::post('category','CategoryController@searchCategory')->name('admin#searchCategory');

    //Pizza
    Route::get('pizza','PizzaController@pizza')->name('admin#pizza');
    Route::get('createPizza','PizzaController@createPizza')->name('admin#createPizza');
    Route::post('insertPizza','PizzaController@insertPizza')->name('admin#insertPizza');
    Route::get('deletePizza/{id}','PizzaController@deletePizza')->name('admin#deletePizza');


});

Route::group(['prefix' => 'user'],function(){
    Route::get('user','UserController@index')->name('user#index');

});