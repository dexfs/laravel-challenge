<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersDeleteController extends Controller
{
    public function __invoke($id)
    {
        $this->validator(['id' => $id])->validate();
        $user = User::findOrFail($id);
        $user->delete();

        return request()->wantsJson()
            ? response('', 200)
            : response('', 400);

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'id' => ['required'],
        ]);
    }

}
