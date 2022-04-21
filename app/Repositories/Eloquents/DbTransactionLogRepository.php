<?php

namespace App\Repositories\Eloquents;

use App\Models\TransactionLog;
use App\Repositories\Interfaces\TransactionLogRepository;

class DbTransactionLogRepository extends DbRepository implements TransactionLogRepository
{
    /**
     *  @param NFT $model
     *
     */
    function __construct(TransactionLog $model)
    {
        $this->model = $model;
    } 

    public function getTransactionByTokenId($tokenId)
    {
        return $this->model->where('tokenId', $tokenId)->get();
    }

    public function getTransactionByAddress($address)
    {
        return $this->model
        ->where('from', $address)
        ->orwhere('to', $address)
        ->get();
    }
}
