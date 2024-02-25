<?php

namespace App\Http\Controllers\Api;

use App\Events\UserCreated;
use App\Facades\AuthFacade;
use App\Http\Controllers\Controller;
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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Nette\Utils\Json as UtilsJson;
use Nette\Utils\Random;
use Random\Randomizer;

use function PHPUnit\Framework\isNull;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login', 'register', 'VerifyEmail']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(StoreUserRequest $request)
    {
        $unverifiedUser = AuthFacade::register($request);
        return response()->json(['user' => $unverifiedUser], 200);
    }
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function VerifyEmail(VerifyUserRequest $request)
    {
        // return isNull(AuthFacade::verifyEmail($request)) ?
        // response()->json(['status' => 'failed'], 400) :
        // response()->json(['user' => AuthFacade::verifyEmail($request)]);
        return response()->json(AuthFacade::verifyEmail($request));
    }
}
