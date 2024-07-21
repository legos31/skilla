<?php

namespace App\Http\Request\Api;

class UpdateUserFormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function authorize() :bool
    {
        return auth()->check();
    }

    public function rules() :array
    {
        return [
            [
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8',
            ]
        ];
    }
}
