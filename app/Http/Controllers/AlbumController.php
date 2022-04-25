<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\AlbumRepository;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    protected $albumRepository;

    public function __construct(AlbumRepository $albumRepository)
    {
        $this->middleware('auth:api',['except' => ['index']]);
        $this->albumRepository = $albumRepository;
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
            $this->albumRepository->destroy($id);
            $statusCode = 200;
            $message = "Delete Album successful!";
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
}
