<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

// /**
//  * @method \JsonResponse register(\App\Http\Requests\StoreUserRequest $request)
//  */

class AuthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'auth_service';
    }
}
