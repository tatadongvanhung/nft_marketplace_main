<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserRepository;
use Illuminate\Http\Request\Str;
use Illuminate\Http\Request;


class UsersController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        // $this->middleware('auth:api',['except' => ['index']]);
        $this->userRepository = $userRepository;
    }
    public function index()
    {
        $users = $this->userRepository->all();
        return response()->json($users, 200);
    }

    public function getUserInfo(){
        $user = auth()->user();
        if(!$user){
            $statusCode = 403;
            return response()->json('User not found !', $statusCode); 
        }
        $statusCode = 200;
        return response()->json($user, $statusCode); 
    }

    public function update($address, Request $request)
    {
        $user = $this->userRepository->findUserByMetamaskAddress($address);
        if (!$user) {
            $statusCode = 404;
            return response()->json('User not found !', $statusCode);
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


    public function getUserByMetamaskAddress($address)
    {
        $user = $this->userRepository->findUserByMetamaskAddress($address);
        $statusCode = 200;
        if (!$user) {
            $statusCode = 404;
            return response()->json('User not found!', $statusCode);
        }
        return response()->json($user, $statusCode);
    }

    public function getListUserByListAddress(Request $request)
    {
        $users = $this->userRepository->getListUserByListAddress($request->address);
        $statusCode = 200;
        return response()->json($users, $statusCode);
    }

}
