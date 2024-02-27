<?php

namespace App\Http\Controllers\Api;

use App\Events\UserCreated;
use App\Facades\AuthFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetVerifyCodeRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Models\UnverifiedUser;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Nette\Utils\Json as UtilsJson;
use Nette\Utils\Random;
use Random\Randomizer;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['register', 'verifyEmail','login', 'resetVerifyCode']]);
    }

    public function register(StoreUserRequest $request)
    {
        $unverifiedUser = AuthFacade::register($request);
        return response()->json(['user' => $unverifiedUser], 200);
    }

    public function verifyEmail(VerifyUserRequest $request)
    {
        return empty($user = AuthFacade::verifyEmail($request)) ?
        response()->json(['status' => 'failed'], 400) :
        response()->json(['user' => $user], 200);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }

    public function resetVerifyCode(ResetVerifyCodeRequest $request)
    {
        $unverifiedUser = AuthFacade::resetVerifyCode($request);
        return response()->json(['status' => 'success'], 200);
    }

}
