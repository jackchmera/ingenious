<?php

declare(strict_types=1);

use App\Modules\Invoices\Infrastructure\Controller\Invoices\ApproveController;
use App\Modules\Invoices\Infrastructure\Controller\Invoices\RejectController;
use App\Modules\Invoices\Infrastructure\Controller\Invoices\ShowController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/invoices/{invoiceId}', ShowController::class);
Route::get('/invoices/{invoiceId}/approve', ApproveController::class);
Route::get('/invoices/{invoiceId}/reject', RejectController::class);
