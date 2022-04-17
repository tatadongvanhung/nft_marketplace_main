<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\NFTController;
use App\Models\Genre;
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

Route::get('/nft/album-id/{id}', [NFTController::class, 'getListByAblumId'])->name('nft-get-list-by-album-id');
Route::get('/nft/genre-id/{id}', [NFTController::class, 'getListByGenreId'])->name('nft-get-list-by-genre-id');

Route::get('/nft/search/{search}', [NFTController::class, 'search'])->name('nft-search');

# album API
Route::get('/album/index', [AlbumController::class, 'index'])->name('album-index');
Route::get('/album/get/{cid}', [AlbumController::class, 'show'])->name('album-get-id');
Route::post('/album/create', [AlbumController::class, 'create'])->name('create-album');
Route::get('/album/delete/{cid}', [AlbumController::class, 'delete'])->name('delete-album');

# genre API
Route::get('/genre/index', [GenreController::class, 'index'])->name('genre-index');
Route::get('/genre/get/{cid}', [GenreController::class, 'show'])->name('genre-get-id');
Route::post('/genre/create', [GenreController::class, 'create'])->name('create-genre');
Route::get('/genre/delete/{cid}', [GenreController::class, 'delete'])->name('delete-genre');
