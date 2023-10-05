<?php

namespace App\Http\Controllers\Auth\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Admin\UserRequest;
use App\Http\Resources\Auth\AdminResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin-api');
    }

    public function show()
    {
      $user = new AdminResource(Auth::guard('admin-api')->user());
      $response = generateResponse($user,$user ? true:false,'',[],'object');
        return $response;
    }
    public function update(UserRequest $request)
    {
        $admin = Auth::guard('admin-api')->user();
        $admin->update($request->only('name', 'email', 'password'));
        return new AdminResource($admin);
    }

    public function destroy()
    {
        Auth::guard('admin-api')->user()->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
