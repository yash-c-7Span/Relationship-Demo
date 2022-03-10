<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder;

class UserService
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function collection($input = null)
    {
        $query = $this->user->getQB()->paginate();
        return $query;
    }

    public function store(object $input)
    {
        $data = $this->user->create([
            'name' => $input->name,
            'email' => $input->email,
            'password' => Hash::make($input->password),
            'password_view' => $input->password,
            'is_active' => isset(User::STATUS['ACTIVE']) ? User::STATUS['ACTIVE'] : 0,
            'role' => User::USER_ROLE,
        ]);

        return $data;
    }

    public function resource(int $id)
    {
        $data = $this->user->getQB()->find($id);
        if (empty($data)) {
            throw new CustomException("User Not Found.");
        }
        return $data;
    }

    public function update(int $id, object $input)
    {
        $data = $this->resource($id);
        if (isset($data['error'])) {
            return $data;
        }

        $data->update([
            'name' => $input->name,
            'email' => $input->email,
            'password' => Hash::make($input->password),
            'password_view' => $input->password,
        ]);

        return $data;
    }

    public function delete(int $id)
    {

        $data = $this->resource($id);
        if (isset($data['error'])) {
            return $data;
        }

        $data->orders()->delete();
        $data = $data->delete();
        return ['success' => $data];
    }
}
