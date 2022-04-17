<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\GenreRepository;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    protected $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }
    
    public function index()
    {
        $albums = $this->genreRepository->all();
        return response()->json($albums, 200);
    }

    public function show($id)
    {
        $album = $this->genreRepository->findById($id);
        $statusCode = 200;
        if (!$album)
            $statusCode = 404;

        return response()->json($album, $statusCode);
    }

    public function delete($id)
    {
        $album = $this->genreRepository->findById($id);

        $statusCode = 404;
        $message = "Genre not found!";
        if ($album) {
            $this->genreRepository->destroy($id);
            $statusCode = 200;
            $message = "Delete genre successful!";
        }

        return response()->json($message, $statusCode);
    }

    public function create(Request $request)
    {
        $params = [
            'name' => $request->name,
            'description' => $request->description ?? null
        ];
        $album = $this->genreRepository->create($params);
        $statusCode = 200;
        if (!$album && !$params)
            $statusCode = 404;
        return response()->json($album, $statusCode);
    }
}
