<?php
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Headers: Authorization');

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PassportAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CustomerController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

Route::post('login-verify', function (Request $request) {

    $info = [
        'success' => false,
        'token' => null,
    ];

    $user = User::where('email', $request->email)->first();

    if (!empty($user) && Hash::check($request->password, $user->password)) {
        $info['success'] = true;
        $token = $user->createToken($user->id)->plainTextToken;
        return [
            'success' => true,
            'token' => $token,
        ];
    } else {
        return [
            'success' => false,
        ];
    }
});

// Route::middleware('auth:sanctum')->get('/auth-user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    // Route::get('get-user', [AuthController::class, 'userInfo']);
    Route::get('auth-user', [AuthController::class, 'userInfo']);
    // Route::resource('customer', CustomerController::class)->only(['index', 'show']);
});
Route::apiResource('/posts', PostController::class);
Route::resource('products', ProductController::class);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
    Route::resource('customer', CustomerController::class)->only(['index', 'show']);

// Route::middleware('auth:api')->group(function () {
//     Route::get('get-user', [PassportAuthController::class, 'userInfo']);
//     Route::resource('products', [ProductController::class]);
//     Route::resource('customer', CustomerController::class)->only(['index', 'show']);
// });