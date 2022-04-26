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
        return $this->model
        ->select(
            'transactionlogs.*',
            'nfts.name',
            'nfts.cover_photo',
            'nfts.cid'
        )
        ->leftjoin('nfts', function($join){
            $join->on('nfts.tokenId', '=', 'transactionlogs.tokenId')
                ->whereNull('nfts.deleted_at');
        })
        ->where('transactionlogs.tokenId', $tokenId)
        ->get();
    }

    public function getTransactionByAddress($address)
    {
        return $this->model
        ->select(
            'transactionlogs.*',
            'nfts.cid',
            'nfts.name',
            'nfts.cover_photo',
        )
        ->leftjoin('nfts', function($join){
            $join->on('nfts.tokenId', '=', 'transactionlogs.tokenId')
                ->whereNull('nfts.deleted_at');
        })
        ->where('from', $address)
        ->orwhere('to', $address)
        ->get();
    }
}
