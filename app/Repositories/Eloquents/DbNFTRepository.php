<?php

namespace App\Repositories\Eloquents;

use App\Models\NFT;
use App\Repositories\Interfaces\NFTRepository;

class DbNFTRepository extends DbRepository implements NFTRepository
{
    /**
     *  @param NFT $model
     *
     */
    function __construct(NFT $model)
    {
        $this->model = $model;
    } 

    public function getNFTByCID($cid)
    {
        return $this->model->where('cid', $cid)->first();
    }
}
