<?php

namespace App\Http\Request\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserFormRequest extends FormRequest
{
    public function authorize() :bool
    {
        return true;
    }

    public function rules() :array
    {
        return [
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email:dns|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]
        ];
    }
}
