<?php

use App\Http\Controllers\AlbumController;
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


Route::get('/album/index', [AlbumController::class, 'index'])->name('album-index');
Route::get('/album/get/{cid}', [AlbumController::class, 'show'])->name('album-get-id');
Route::post('/album/create', [AlbumController::class, 'create'])->name('create-album');
Route::get('/album/delete/{cid}', [AlbumController::class, 'delete'])->name('delete-album');
