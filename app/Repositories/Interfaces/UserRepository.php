<?php

namespace App\Repositories\Interfaces;

interface UserRepository
{
    public function findUserByMetamaskAddress($address);

    public function getListUserByListAddress($address);
}
