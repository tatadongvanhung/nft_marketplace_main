<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Interfaces\UserRepository;

class DbUserRepository extends DbRepository implements UserRepository
{
    /**
     *  @param NFT $model
     *
     */
    function __construct(User $model)
    {
        $this->model = $model;
    } 

    public function findUserByMetamaskAddress($address)
    {
        return $this->model->where('metamask_address', $address)->first();
    }

    public function getListUserByListAddress($address)
    {
        return $this->model->whereIn('metamask_address', $address)->get();
    }
}
