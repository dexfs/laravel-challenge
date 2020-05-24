<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\User;

class UsersPluckController extends Controller
{
    public function __invoke()
    {
        $id = request()->query('id', null);

        return request()->wantsJson()
            ? response()->json($this->dataSource($id))
            : response('', 400);

    }

    private function dataSource($id)
    {
        if (!empty($id)) {
            return User::find($id)->only(['id', 'name']);
        }

        return User::all()->map(function ($user) {
            return [
                'id'   => $user->id,
                'name' => $user->name,
            ];
        });
    }
}
