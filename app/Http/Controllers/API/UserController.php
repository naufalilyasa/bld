<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\UserCollection;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($id = null)
    {
        $user = auth('api')->user();

        if (is_null($id))
        {
            if ($user->hasPermissionTo('read users', 'api')) {
                return new UserCollection(User::paginate());
            }
        } else {
            if ($user->hasPermissionTo('read a user', 'api')) {
                return User::find($id)->firstOrFail();
            }
        }

        return [];
    }
}
