<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Support\Facades\DB;

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

    public function countUserInTime($from, $to)
    {
        if(!empty($from) && !empty($to)) {
            return $this->model
            ->where(DB::raw('DATE(created_at)'), '>=', $from)
            ->where(DB::raw('DATE(created_at)'), '<=', $to)
            ->withTrashed()->count();
        }
        return $this->model->withTrashed()->count();
    }
}
