<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\User as UserRequest;
use App\Http\Resources\User\Collection as UserCollection;
use App\Http\Resources\User\Resource as UserResource;
use App\Services\UserService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $data = $this->userService->collection($request->all());
        return $this->collection(new UserCollection($data));
    }

    public function store(UserRequest $request)
    {
        $data = $this->userService->store((object) $request->validated());
        return $this->resource(new UserResource($data));
    }

    public function show($id)
    {
        $data = $this->userService->resource($id);
        return $this->resource(new UserResource($data));
    }

    public function update(UserRequest $request, $id)
    {
        $data = $this->userService->update($id,(object) $request->validated());
        return $this->resource(new UserResource($data));
    }

    public function destroy($id)
    {
        $data = $this->userService->delete($id);
        return $this->success($data,200);
    }
}
