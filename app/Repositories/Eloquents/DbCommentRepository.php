<?php

namespace App\Repositories\Eloquents;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepository;

class DbCommentRepository extends DbRepository implements CommentRepository
{
    /**
     *  @param Comment $model
     *
     */
    function __construct(Comment $model)
    {
        $this->model = $model;
    } 

    public function getCommentByNFTId($nftId)
    {
        return $this->model
        ->where('nft_id', $nftId)
        ->orderBy('id', 'desc')
        ->get();
    }
}
