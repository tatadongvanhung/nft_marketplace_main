<?php

use App\Http\Controllers\NFTController;
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

// Route::get('/nfts', 'NFT@index')->name('customers.all');
Route::get('/nft/index', [NFTController::class, 'index'])->name('nft-index');
Route::get('/nft/get/{cid}', [NFTController::class, 'getNFTByCID'])->name('nft-get-cid');
Route::post('/nft/create', [NFTController::class, 'createNFT'])->name('create-nft');
Route::get('/nft/delete/{cid}', [NFTController::class, 'deleteNFT'])->name('delete-nft');
