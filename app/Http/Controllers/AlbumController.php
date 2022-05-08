<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\AlbumRepository;
use App\Repositories\Interfaces\NFTRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    protected $albumRepository;
    protected $nftRepository;

    public function __construct(AlbumRepository $albumRepository, NFTRepository $nftRepository)
    {
        // $this->middleware('auth:api',['except' => ['index']]);
        $this->albumRepository = $albumRepository;
        $this->nftRepository = $nftRepository;
    }
    
    public function index()
    {
        $albums = $this->albumRepository->all();
        return response()->json($albums, 200);
    }

    public function show($id)
    {
        $album = $this->albumRepository->findById($id);
        $statusCode = 200;
        if (!$album)
            $statusCode = 404;

        return response()->json($album, $statusCode);
    }

    public function delete($id)
    {
        $album = $this->albumRepository->findById($id);

        $statusCode = 404;
        $message = "Album not found!";
        if ($album) {
            $statusCode = 200;
            $message = "Delete Album successful!";
            try {
                $nfts = $this->nftRepository->findWhere(['album_id' => $id]);
                DB::beginTransaction();
                $this->albumRepository->destroy($id);
                foreach($nfts as $nft) {
                    $this->nftRepository->update(['album_id' => NULL], $nft->id);
                }
                DB::commit();
            } catch(Exception $ex) {
                DB::rollBack();
                $statusCode = 500;
                $message = "Delete Album fail!";
            }
        }
        return response()->json($message, $statusCode);
    }

    public function create(Request $request)
    {
        $params = [
            'name' => $request->name,
            'description' => $request->description ?? null,
            'album_picture' => $request->album_picture ?? null,
            'metamask_address' => $request->metamask_address ?? null
        ];
        $album = $this->albumRepository->create($params);
        $statusCode = 200;
        if (!$album && !$params)
            $statusCode = 404;
        return response()->json($album, $statusCode);
    }

    public function getAlbumByMetamaskAddress($address)
    {
        $albums = $this->albumRepository->getAlbumByMetamaskAddress($address);
        $statusCode = 200;
        return response()->json($albums, $statusCode);
    }
}
