<?php

namespace App\Http\Controllers\Api;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Request\Api\StoreUserFormRequest;
use App\Http\Request\Api\UpdateUserFormRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 3);
        $search = $request->input('name');

        $query = User::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $users = $query->paginate($perPage);

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserFormRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
            ]);

        if(!$user) {
            return abort(500, 'Error create user.');
        }

        $token = $user->createToken('token', ['admin'])->plainTextToken;

        event(new UserRegistered($user));

        return response()->json(['user' => $user, 'token' => $token ?? ''], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return User::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserFormRequest $request, string $id): JsonResponse
    {
        $user = User::findOrFail($id);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        User::destroy($id);
        return response()->json(null, 204);
    }

}
