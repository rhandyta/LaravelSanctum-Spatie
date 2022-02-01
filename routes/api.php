<?php

use App\Http\Controllers\HomeController;
use App\Http\Resources\RolesResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//return $request->user();
//});

Route::group(['prefix' => 'auth'], function () {
	Route::post('register', [HomeController::class, 'register'])->name('register');
	Route::post('login', [HomeController::class, 'login'])->name('login');
});
Route::middleware('auth:sanctum')->get('/logout', function () {
	auth()->user()->tokens()->delete();
	return response()->json(['success' => true, 'message' => 'you are loggout'], 200);
});

Route::get('all', function () {
	$users =  User::with('roles', 'permissions')->latest()->get();
	return RolesResource::collection($users);
});

Route::middleware('auth:sanctum')->get('user', function (Request $request) {
	$users = $request->user();
	if ($users->can('view')) {
		return RolesResource::make($request->user());
	}
	return response()->json(['message' => 'GAGAL BRE']);
});

Route::middleware('auth:sanctum')->get('moderator', function (Request $request) {
	$users = $request->user();
	if ($users->can('delete')) {
		return RolesResource::make($request->user());
	}
	return response()->json(['message' => 'GAGAL BRE']);
});


Route::middleware('auth:sanctum')->get('admin', function (Request $request) {
	$users = $request->user();
	if ($users->can('view', 'add', 'edit', 'delete')) {
		return RolesResource::make($request->user());
	}
	return response()->json(['message' => 'GAGAL BRE']);
});
