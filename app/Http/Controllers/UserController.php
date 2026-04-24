<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravolt\Avatar\Avatar;

class UserController extends Controller
{
    public function isEmailTaken($email)
    {
        $count = User::where('email', $email)->count();
        return $count > 0;

    }
    public function getUserById($id)
    {
        try {
            return User::where('id', $id)->first();
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function createAvatar($name)
    {
        $avatar = new Avatar([]);
        return $avatar->create($name);
    }
    public function createUser($name, $email, $password, $role = "USER")
    {
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'avatar' => $this->createAvatar($name),
        ]);
    }


}
