<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;

class UsersListController extends Controller
{
    public function __invoke()
    {
        $user = User::paginate();

        return request()->wantsJson()
            ? response()->json($user)
            : response('', 400);

    }
}
