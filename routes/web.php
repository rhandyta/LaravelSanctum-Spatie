<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
	// return view('welcome');
	// $user = auth()->user();
	// $user = User::find(9);
	// $user->givePermissionTo('view');
	// $user->assignRole('moderator');
	// $user->assignRole('user');
	// $role = Role::findById(2);
	// $role->givePermissionTo('add post');
	// $user->givePermissionTo('view post');
	// $role->syncPermissions('add', 'edit', 'delete', 'view');
	// $role->syncPermissions('view post');
	// dd($user->can('view post'));
	// dd($role);
});
Auth::routes();

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});

Route::get('all', function () {
	return response()->json(['message' => 'HTTP ALL']);
});

Route::get('user', function (Request $request) {
	$user = $request->user();
	if ($user->roles[0]->name == user) {
		$user = $user;
		array_push($user, $user->roles[0]);
		return response()->json($user);
	}
	return response()->json(['message' => 'GAGAL BRE']);
});

Route::get('moderator', function (Request $request) {
	$moderator = $request->user();
	if ($moderator->roles[0]->name == moderator) {
		$user = $moderator;
		array_push($user, $moderator->roles[0]);
		return response()->json($user);
	}
	return response()->json(['message' => 'GAGAL BRE']);
});


Route::get('admin', function (Request $request) {
	$admin = $request->user();
	if ($admin->roles[0]->name == admin) {
		$user = $admin;
		array_push($user, $admin->roles[0]);
		return response()->json($user);
	}
	return response()->json(['message' => 'GAGAL BRE']);
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
