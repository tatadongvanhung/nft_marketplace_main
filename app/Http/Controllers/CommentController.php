<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->middleware('auth:api',['except' => ['commentNFTindex']]);
        $this->commentRepository = $commentRepository;
    }

    public function commentNFTindex($nftId)
    {
        $comments = $this->commentRepository->getCommentByNFTId($nftId);
        $statusCode = 200;
        return response()->json($comments, $statusCode);
    }

    public function delete($id)
    {
        $user = auth()->user()->metamask_address ?? '';
        $statusCode = 200;
        $comment = $this->commentRepository->findById($id);
        $message = "Delete success!";
        if(!$comment || !$user) {
            $message = "404";
            $statusCode = 404;
        } elseif($comment->metamask_address != $user) {
            $message = "401";
            $statusCode = 401;
        } else {
            $this->commentRepository->destroy($id);
        }
        return response()->json($message, $statusCode);
    }

    public function create(Request $request)
    {
        $params = [
            'nft_id' => $request->nft_id,
            'metamask_address' => $request->metamask_address ?? null,
            'content' => $request->content ?? null
        ];
        $comment = $this->commentRepository->create($params);
        $statusCode = 200;
        if (!$comment)
            $statusCode = 404;
        return response()->json($comment, $statusCode);
    }

    public function update($id, Request $request)
    {
        $user = auth()->user()->metamask_address ?? '';
        // $user = '2';
        $comment = $this->commentRepository->findById($id);
        $message = "Update success!";
        $statusCode = 200;
        if(!$comment) {
            $message = "Comment not found!";
            $statusCode = 404;
        } elseif($comment->metamask_address != $user) {
            $message = "Unauthorized 401";
            $statusCode = 401;
        } else {
            $params = [
                'content' => $request->content ?? null
            ];
            $this->commentRepository->update($params, $id);
        }
        return response()->json($message, $statusCode);
    }
}
