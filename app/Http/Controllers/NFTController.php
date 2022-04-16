<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\NFTRepository;
use Illuminate\Http\Request;

class NFTController extends Controller
{
    protected $nftRepository;

    public function __construct(NFTRepository $nftRepository)
    {
        $this->nftRepository = $nftRepository;
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
            'album_id' => (int) $request->album_id
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
}
