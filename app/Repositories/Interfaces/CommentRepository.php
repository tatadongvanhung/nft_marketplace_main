<?php

namespace App\Repositories\Interfaces;

interface CommentRepository
{
    public function getCommentByNFTId($nftId);

    public function countCommentInTime($from, $to);

}
