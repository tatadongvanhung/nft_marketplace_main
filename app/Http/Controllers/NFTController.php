<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\AlbumRepository;
use App\Repositories\Interfaces\GenreRepository;
use App\Repositories\Interfaces\NFTRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NFTController extends Controller
{
    protected $nftRepository;
    protected $albumRepository;
    protected $genreRepository;

    public function __construct
    (
        NFTRepository $nftRepository, 
        AlbumRepository $albumRepository,
        GenreRepository $genreRepository
    ) {
        $this->middleware('auth:api', ['except' => ['getListByGenreId','getListByAblumId','index','search']]);
        $this->nftRepository = $nftRepository;
        $this->albumRepository = $albumRepository;
        $this->genreRepository = $genreRepository;
    }

    public function index()
    {
        $nfts = $this->nftRepository->all();
        return response()->json($nfts, 200);
    }

    public function getNFTByCID($cid)
    {
        $nft = $this->nftRepository->getNFTByCID($cid);
        $statusCode = 200;
        if (!$nft)
            $statusCode = 404;

        return response()->json($nft, $statusCode);
    }

    public function createNFT(Request $request)
    {
        $params = [
            'name' => $request->name ?? null,
            'album_id' => (int) $request->album_id ?? null,
            'genre_id' => (int) $request->genre_id ?? null,
            'tokenId' => (int) $request->tokenId ?? null,
            'cover_photo' => $request->cover_photo ?? null,
        ];
        $nft = $this->nftRepository->create($params);
        $statusCode = 200;
        if (!$nft && !$params)
            $statusCode = 404;
        return response()->json($nft, $statusCode);
    }

    public function deleteNFT($id)
    {
        $nft = $this->nftRepository->findById($id);
        $statusCode = 404;
        $message = "NFT not found!";
        if ($nft) {
            $this->nftRepository->destroy($nft->id);
            $statusCode = 200;
            $message = "Delete NFT successful!";
        }

        return response()->json($message, $statusCode);
    }

    public function getListByAblumId($albumId)
    {
        $album = $this->albumRepository->findById($albumId);
        $statusCode = 404;
        $message = "Album not found!";
        if($album) {
            $statusCode = 200;
            $nfts = $this->nftRepository->getListNFTbyAlbumId($albumId);
            return response()->json($nfts, $statusCode);
        }
        return response()->json($message, $statusCode);
    }

    public function getListByGenreId($genreId)
    {
        $album = $this->genreRepository->findById($genreId);
        $statusCode = 404;
        $message = "Genre not found!";
        if($album) {
            $statusCode = 200;
            $nfts = $this->nftRepository->getListNFTbyGenreId($genreId);
            return response()->json($nfts, $statusCode);
        }
        return response()->json($message, $statusCode);
    }

    public function search($search)
    {
        $nfts = $this->nftRepository->searchNFT($search);
        $albums = $this->albumRepository->searchAlbum($search);
        $result = [
            'nfts' => $nfts,
            'albums' =>$albums
        ];
        return response()->json($result, 200);
    }

    public function show($id)
    {
        $nft = $this->nftRepository->findById($id);
        $statusCode = 200;
        if (!$nft)
            $statusCode = 404;

        return response()->json($nft, $statusCode);
    }

    public function getNFTNotInAblum()
    {
        // $user = auth()->user();
        $statusCode = 200;
        // if (!$user) {
        //     $statusCode = 401;
        //     $message = "Unauthorized";
        //     return response()->json($message, $statusCode);
        // }
        $nft = $this->nftRepository->getNFTNotInAblum();
        return response()->json($nft, $statusCode);
    }

    public function updateAlbum(Request $request) {
        $token_ids = $request->token_ids;
        $albumId = $request->ablum_id ?? '';
        $statusCode = 200;
        $message = "Update success!";
        try {
            DB::beginTransaction();
            foreach ($token_ids as $token) {
                $nft = $this->nftRepository->findNFTByTokenId($token);
                $this->nftRepository->update(['album_id' => $albumId], $nft->id);
            }
            DB::commit();
            return response()->json($message, $statusCode);
        } catch(Exception $e) {
            DB::rollBack();
            $statusCode = 500;
            $message = "Update fail!";
            return response()->json($message, $statusCode);
        }  
    }

    public function getByAlbumNull(Request $request)
    {
        $tokenIds=$request->token_ids;
        $nfts = $this->nftRepository->getByTokenIdAndAbumNull($tokenIds);
        $statusCode = 200;
        return response()->json($nfts, $statusCode);
    }

    public function update($id, Request $request)
    {
        $nft = $this->nftRepository->findById($id);
        $statusCode = 200;
        $message = "Update success!";
        if(!$nft) {
            $statusCode = 404;
            $message = "NFT not found!";
        } 
        $update = $this->nftRepository->update(['tokenId' => $request->tokenId], $id);
        return response()->json($message, $statusCode);
    }
}
