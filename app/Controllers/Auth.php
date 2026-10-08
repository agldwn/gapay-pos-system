<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $helpers = ['form', 'url'];

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(site_url('dashboard'));
        }

        return view('auth/login', [
            'title' => 'Staff Login'
        ]);
    }

    public function attemptLogin()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Please enter both username and password.');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel
            ->where('username', $username)
            ->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Incorrect username or password.');
        }

        session()->set([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'full_name' => $user['full_name'],
            'avatar' => $user['avatar'],
            'isLoggedIn' => true
        ]);

        return redirect()
            ->to(site_url('dashboard'))
            ->with('success', 'Welcome, ' . $user['full_name'] . '!');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()
            ->to(site_url('login'))
            ->with('success', 'You have been logged out.');
    }
}