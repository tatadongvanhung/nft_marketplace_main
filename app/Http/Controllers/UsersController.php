<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserRepository;
use Illuminate\Http\Request\Str;

class UsersController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // public function loginMetamask($address)
    // {
    //     $user = $this->userRepository->findUserByMetamaskAddress($address);
    //     if (!$user) {
    //         $params = [
    //             'metamask_address' => $address,
    //             'name' => $address
    //         ];
    //         $user = $this->userRepository->create($params);
    //     }
    //     return response()->json($user, 200);
    // }

    public function loginMetamask($publicAddress)
    {
        $user = $this->userRepository->findUserByMetamaskAddress($address);
        if (!$user) {
            $params = [
                'metamask_address' => $publicAddress,
                'name' => 'New User',
                'nonce' => Str::random(9);
            ];
            $user = $this->userRepository->create($params);
        }
        return response()->json($user, 200);
    }

    public function authenMetamask($publicAddress,$signature)
    {
       //api 
       $user = $this->userRepository->findUserByMetamaskAddress($address);
        

    }

    public function update($address, Request $request)
    {
        $user = $this->userRepository->findUserByMetamaskAddress($address);
        if (!$user) {
            $statusCode = 404;
            return response()->json('User not found!', $statusCode);
        }
        $params = [
            'name' => $request->name ?? null,
            'description' => $request->description ?? null,
            'avatar_picture' => $request->avatar_picture ?? null,
            'cover_picture' => $request->cover_picture ?? null,
        ];
        $userUpdate = $this->userRepository->update($params, $user->id);
        $statusCode = 200;
        if (!$userUpdate && !$params)
            $statusCode = 404;
        $user1 = $this->userRepository->findById($user->id);
        return response()->json($user1, $statusCode);
    }
}
