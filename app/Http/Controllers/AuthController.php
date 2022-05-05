<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use kornrunner\Keccak;
use Elliptic\EC;
use Illuminate\Support\Str;
use App\Repositories\Interfaces\UserRepository;

class AuthController extends Controller
{
    protected $userRepository;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository) {
        $this->middleware('auth:api', ['except' => ['login', 'register','loginMetamask','authMetamask']]);
        $this->userRepository = $userRepository;
    }

    protected function verifySignature($message, $signature, $publicAddress): bool
    {
        $messageLength = strlen(strval($message));
        $hash = Keccak::hash("\x19Ethereum Signed Message:\n{$messageLength}{$message}", 256);
        $sign = [
            "r" => substr($signature, 2, 64),
            "s" => substr($signature, 66, 64)
        ];

        $recId  = ord(hex2bin(substr($signature, 130, 2))) - 27;

        if ($recId != ($recId & 1)) {
            return false;
        }

        $publicKey = (new EC('secp256k1'))->recoverPubKey($hash, $sign, $recId);
        return $this->pubKeyToAddress($publicKey) === Str::lower($publicAddress);
    }


    protected function pubKeyToAddress($publicKey): string
    {
        return "0x" . substr(Keccak::hash(substr(hex2bin($publicKey->encode("hex")), 1), 256), 24);
    }

    public function loginMetamask(Request $request)
    {
        $publicAddress = $request->input('publicAddress');
        $nonce = Str::random(9);

        if(!$publicAddress){
            return response()->json("publicAddress is required !", 500);
        }
        $user = $this->userRepository->findUserByMetamaskAddress($publicAddress);
        if (!$user) {
            $params = [
                'metamask_address' => $publicAddress,
                'name' => 'New User',
                'nonce' => $nonce
            ];
            $user = $this->userRepository->create($params);
        }
        return response()->json($user, 200);
    }

    public function authMetamask(Request $request)
    {
       //api 
        $publicAddress = $request->input('publicAddress');
        $signature = $request->input('signature');

        if(!$publicAddress || ! $signature){
            return response()->json("signature or publicAddress is required !", 500);
        }
        $user = $this->userRepository->findUserByMetamaskAddress($publicAddress);
        if($this->verifySignature($user->nonce, $signature,$publicAddress)){
            $user = $this->userRepository->findUserByMetamaskAddress($publicAddress);
            if (!$user) {
                $statusCode = 404;
                return response()->json('User not found !', $statusCode);
            }

            $nonce = Str::random(9);
            $params = [
                'nonce' => $nonce ?? null,
            ];

            $userUpdate = $this->userRepository->update($params, $user->id);

            if (!$token = auth()->login($user)){
                return response()->json(['error' => 'Unauthorized'], 401);
            }
    
            return $this->createNewToken($token);
        }
        $statusCode = 404;
        return response()->json('Authencation failed !', $statusCode); 
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function changePassWord(Request $request) {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $userId = auth()->user()->id;

        $user = User::where('id', $userId)->update(
                    ['password' => bcrypt($request->new_password)]
                );

        return response()->json([
            'message' => 'User successfully changed password',
            'user' => $user,
        ], 201);
    }
}
