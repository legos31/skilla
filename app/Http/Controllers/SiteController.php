<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SiteController extends Controller
{
    public function secret(Request $request)
    {

        return response()->json('Secret page',201);
    }

    public function admin(Request $request)
    {

        return response()->json('Admin page',201);
    }

    public function login(Request $request)
    {

        return response()->json('login page');
    }
}
