<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    protected $helpers = ['form', 'url'];

    public function index()
    {
        $userModel = new UserModel();

        return view('users/index', [
            'title' => 'Staff Members',
            'users' => $userModel->orderBy('id', 'DESC')->findAll()
        ]);
    }

    public function create()
    {
        return view('users/form', [
            'title' => 'Add Staff Member',
            'user' => null,
            'isEdit' => false
        ]);
    }

    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'full_name' => 'required|min_length[2]|max_length[100]',
            'password' => 'required|min_length[6]',
            'avatar' => 'permit_empty|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        if ($userModel->where('username', $this->request->getPost('username'))->first()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'That username is already taken.');
        }

        $avatarName = null;
        $avatar = $this->request->getFile('avatar');

        if ($avatar && $avatar->isValid() && !$avatar->hasMoved()) {
            $avatarName = $avatar->getRandomName();
            $avatar->move(FCPATH . 'uploads/avatars', $avatarName);
        }

        $userModel->insert([
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'avatar' => $avatarName
        ]);

        return redirect()
            ->to(site_url('users'))
            ->with('success', 'Staff member added successfully.');
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()
                ->to(site_url('users'))
                ->with('error', 'Staff member not found.');
        }

        return view('users/form', [
            'title' => 'Edit Staff Member',
            'user' => $user,
            'isEdit' => true
        ]);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()
                ->to(site_url('users'))
                ->with('error', 'Staff member not found.');
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'full_name' => 'required|min_length[2]|max_length[100]',
            'password' => 'permit_empty|min_length[6]',
            'avatar' => 'permit_empty|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');

        $existingUser = $userModel
            ->where('username', $username)
            ->where('id !=', $id)
            ->first();

        if ($existingUser) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'That username is already taken.');
        }

        $data = [
            'username' => $username,
            'full_name' => $this->request->getPost('full_name')
        ];

        $password = $this->request->getPost('password');

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $avatar = $this->request->getFile('avatar');

        if ($avatar && $avatar->isValid() && !$avatar->hasMoved()) {
            $avatarName = $avatar->getRandomName();
            $avatar->move(FCPATH . 'uploads/avatars', $avatarName);
            $data['avatar'] = $avatarName;

            if ($user['avatar']) {
                $oldAvatar = FCPATH . 'uploads/avatars/' . $user['avatar'];

                if (is_file($oldAvatar)) {
                    unlink($oldAvatar);
                }
            }
        }

        $userModel->update($id, $data);

        return redirect()
            ->to(site_url('users'))
            ->with('success', 'Staff member updated successfully.');
    }

    public function delete($id)
    {
        if ((int) session()->get('user_id') === (int) $id) {
            return redirect()
                ->to(site_url('users'))
                ->with('error', 'You cannot delete the account currently in use.');
        }

        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()
                ->to(site_url('users'))
                ->with('error', 'Staff member not found.');
        }

        if ($user['avatar']) {
            $avatarPath = FCPATH . 'uploads/avatars/' . $user['avatar'];

            if (is_file($avatarPath)) {
                unlink($avatarPath);
            }
        }

        $userModel->delete($id);

        return redirect()
            ->to(site_url('users'))
            ->with('success', 'Staff member deleted successfully.');
    }
}