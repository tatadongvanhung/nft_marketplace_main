<?php

namespace App\Repositories\Interfaces;

interface AlbumRepository
{
    public function searchAlbum($search);

    public function getAlbumByMetamaskAddress($address);

    public function countAlbumInTime($from, $to);
}
