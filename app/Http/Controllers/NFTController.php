<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\AlbumRepository;
use App\Repositories\Interfaces\GenreRepository;
use App\Repositories\Interfaces\NFTRepository;
use Illuminate\Http\Request;

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
            'cid' => $request->cid,
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

    public function deleteNFT($cid)
    {
        $nft = $this->nftRepository->getNFTByCID($cid);

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
}
