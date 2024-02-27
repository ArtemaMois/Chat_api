<?php

namespace App\Services;

use App\Events\UserCreated;
use App\Events\VerifyEmail;
use App\Http\Requests\ResetVerifyCodeRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Models\UnverifiedUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;

class AuthService
{
    public function register(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);
        $otp = (int)Random::generate(6, '0-9');
        $data['email_verify_code'] = $otp;
        $user = UnverifiedUser::query()->create($data);
        event(new UserCreated($request->email));
        event(new VerifyEmail($request->email, $otp));
        return $user;
    }

    public function verifyEmail(VerifyUserRequest $request)
    {
        $unverifiedUser = UnverifiedUser::query()->where('email', $request->email)->first();
        if ($unverifiedUser->email_verify_code == $request->email_verify_code) {
            $user = User::query()->create([
                'name' => $unverifiedUser->name,
                'surname' => $unverifiedUser->surname,
                'email' => $unverifiedUser->email,
                'password' => $unverifiedUser->password,
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            $unverifiedUser->delete();
            return $user;
        } else {
            return null;
        }
    }

    public function resetVerifyCode(ResetVerifyCodeRequest $request)
    {
        $otp = (int)Random::generate(6, '0-9');
        $unverifiedUser = UnverifiedUser::query()->where('email', $request->email)->first();
        $unverifiedUser->update(['email_verify_code' => $otp]);
        event(new VerifyEmail($request->email, $otp));
        return $unverifiedUser;
    }
}
