<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Services\UserServices;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private UserServices $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    public function register(CreateUserRequest $request)
    {
        $validatedPayload = $request->validated();
        $this->userServices->register($validatedPayload);

        return response()->json(['message' => 'User created successfully']);
    }

    public function findAll()
    {
        return response()->json($this->userServices->findAll());
    }

    public function findById(Request $request)
    {
        return $this->userServices->findUserById($request->id);
    }

    public function startTransaction(Request $request)
    {

    }
}
