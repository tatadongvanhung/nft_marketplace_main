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
            'album_id' => (int) $request->album_id ?? null
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
}
