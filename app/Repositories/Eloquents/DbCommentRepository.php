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
        ->select(
            'comments.*',
            'users.name as user_name',
            'users.avatar_picture'
        )
        ->leftjoin('users', function($join){
                $join->on('users.metamask_address', '=', 'comments.metamask_address')
                    ->whereNull('users.deleted_at');
            })
        ->where('nft_id', $nftId)
        ->orderBy('id', 'desc')
        ->get();
    }
}
