<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UsersUpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $data = $request->all();
        $this->validator($data)->validate();
        $user = User::findOrFail($id);
        $user->fill($request->all());
        $user->save();

        return $request->wantsJson()
            ? response('', 200)
            : response('', 400);

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['sometimes','required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
    }

}
