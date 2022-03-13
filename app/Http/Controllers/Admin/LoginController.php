<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest:admin'])->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function guard()
    {
        return Auth::guard('admin');
    }
}
