<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\NFTController;
use App\Http\Controllers\TransactionLogController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;
use App\Models\Comment;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    // Route::get('/nfts', 'NFT@index')->name('customers.all');
    
});

Route::get('/nft/index', [NFTController::class, 'index'])->name('nft-index');
Route::get('/nft/get/{cid}', [NFTController::class, 'getNFTByCID'])->name('nft-get-cid');
Route::post('/nft/create', [NFTController::class, 'createNFT'])->name('create-nft');
Route::post('/nft/update-token/{nft_id}', [NFTController::class, 'update'])->name('update-token-nft');
Route::get('/nft/delete/{cid}', [NFTController::class, 'deleteNFT'])->name('delete-nft');
Route::put('/nft/get-nft-by-tokenid-ablum-null', [NFTController::class, 'getByAlbumNull'])->name('get-nft-by-tokenid-ablum-null');

Route::get('/nft/album-id/{id}', [NFTController::class, 'getListByAblumId'])->name('nft-get-list-by-album-id');
Route::get('/nft/genre-id/{id}', [NFTController::class, 'getListByGenreId'])->name('nft-get-list-by-genre-id');

Route::get('/nft/search/{search}', [NFTController::class, 'search'])->name('nft-search');

Route::get('/nft/get-id/{id}', [NFTController::class, 'show'])->name('nft-show');

Route::get('/nft/get-nft-not-in-album', [NFTController::class, 'getNFTNotInAblum'])->name('get-nft-not-in-album');
Route::post('/nft/update-album', [NFTController::class, 'updateAlbum'])->name('nft-update-album');

# album API
Route::get('/album/index', [AlbumController::class, 'index'])->name('album-index');
Route::get('/album/get/{cid}', [AlbumController::class, 'show'])->name('album-get-id');
Route::post('/album/create', [AlbumController::class, 'create'])->name('create-album');
Route::get('/album/delete/{cid}', [AlbumController::class, 'delete'])->name('delete-album');
Route::get('/album/get-by-metamask/{address}', [AlbumController::class, 'getAlbumByMetamaskAddress'])->name('album-get-by');

# genre API
Route::get('/genre/index', [GenreController::class, 'index'])->name('genre-index');
Route::get('/genre/get/{cid}', [GenreController::class, 'show'])->name('genre-get-id');
Route::post('/genre/create', [GenreController::class, 'create'])->name('create-genre');
Route::get('/genre/delete/{cid}', [GenreController::class, 'delete'])->name('delete-genre');

# Transaction
Route::get('/transactionlog/index', [TransactionLogController::class, 'index'])->name('transactionlog-index');
Route::get('/transactionlog/get/{id}', [TransactionLogController::class, 'show'])->name('transactionlog-id');
Route::post('/transactionlog/create', [TransactionLogController::class, 'create'])->name('create-transactionlog');
Route::post('/transactionlog/update/{id}', [TransactionLogController::class, 'update'])->name('update-transactionlog');
Route::get('/transactionlog/delete/{id}', [TransactionLogController::class, 'delete'])->name('delete-transactionlog');

Route::get('/transactionlog/get-tokenid/{tokenid}', [TransactionLogController::class, 'getByTokenId'])->name('transactionlog-getByTokenId');
Route::get('/transactionlog/get-address/{address}', [TransactionLogController::class, 'getByAddress'])->name('transactionlog-getByAddress');

Route::post('/auth/login-metamask', [AuthController::class, 'loginMetamask'])->name('auth-metamask');
Route::post('/auth/auth-metamask', [AuthController::class, 'authMetamask'])->name('auth-metamask');

#users
Route::get('/users/index', [UsersController::class, 'index'])->name('user-index');
Route::post('/users/update/{address}', [UsersController::class, 'update'])->name('users-update');
Route::get('/users/get-user-info', [UsersController::class, 'getUserInfo'])->name('users-info');
Route::get('/users/get-user-by-metamask/{metamask_address}', [UsersController::class, 'getUserByMetamaskAddress'])->name('get-user-by-metamask');

Route::put('/users/get-list-user-by-address', [UsersController::class, 'getListUserByListAddress'])->name('et-list-user-by-address');

#comment
Route::get('/comments/nft/{nftId}', [CommentController::class, 'commentNFTindex'])->name('comment-nft-index');
Route::get('/comments/delete/{id}', [CommentController::class, 'delete'])->name('comment-delete');
Route::post('/comments/create', [CommentController::class, 'create'])->name('comment-create');
Route::post('/comments/update/{id}', [CommentController::class, 'update'])->name('comment-update');

Route::get('/reports/dashboard', [ReportController::class, 'index'])->name('report-dashboard');