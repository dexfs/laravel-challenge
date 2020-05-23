<?php
namespace App\Http\Controllers\Users;

use App\User;
use App\Http\Controllers\Controller;


class IndexController extends Controller
{

    public function index(User $user)
    {
        return view('users.index');
    }
}
