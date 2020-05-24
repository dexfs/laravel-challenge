<?php

namespace App\Http\Controllers\Api;

use App\Services\UserServiceDelete;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersDeleteController extends Controller
{
    /**
     * @var \App\Services\UserServiceDelete
     */
    private $serviceDelete;

    public function __construct(UserServiceDelete $serviceDelete)
    {
        $this->serviceDelete = $serviceDelete;
    }

    public function __invoke($id)
    {
        $this->validator(['id' => $id])->validate();
        $this->serviceDelete->__invoke($id);

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
