<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CommentRepository;
use App\Repositories\Interfaces\UserRepository;
use App\Repositories\Interfaces\AlbumRepository;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $userRepository;
    protected $commentRepository;
    protected $albumRepository;


    public function __construct (
        UserRepository $userRepository,
        CommentRepository $commentRepository,
        AlbumRepository $albumRepository

    ) {
        $this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
        $this->albumRepository = $albumRepository;
    }

    public function index(Request $request)
    {
        $from = $request->from ?? null;
        $to = $request->to ?? null;
        $users = $this->userRepository->countUserInTime($from, $to);
        $comments = $this->commentRepository->countCommentInTime($from, $to);
        $albums = $this->albumRepository->countAlbumInTime($from, $to);
        $statusCode = 200;
        $data = [
            'user_count' => $users ?? 0,
            'comment_count' => $comments ?? 0,
            'album_count' => $albums ?? 0
        ];
        return response()->json($data, $statusCode);
    }
}
