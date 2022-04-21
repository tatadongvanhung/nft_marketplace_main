<?php

namespace App\Repositories\Interfaces;

interface TransactionLogRepository
{
    public function getTransactionByTokenId($tokenId);

    public function getTransactionByAddress($address);
}
