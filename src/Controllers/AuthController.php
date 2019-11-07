<?php

namespace App\Controllers;

class AuthController extends Controller
{
    public function loginAction()
    {
        $username = request('username');
        $password = md5(request('password'));
        $user = $this->repository->table('users')->findBy(['username' => $username, 'password' => $password]);

        if ($user)
        {
            session('user', $user);
        }

        return redirect('posts');
    }
}