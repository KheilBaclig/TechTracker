<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    protected UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index(): string
    {
        $users = $this->model->paginate(10);
        $pager = $this->model->pager;
        return $this->render('users/index', compact('users', 'pager'));
    }

    public function new(): string
    {
        return $this->render('users/form', ['user' => null]);
    }

    public function create()
    {
        $rules = array_merge($this->model->validationRules, [
            'password' => 'required|min_length[6]',
        ]);

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'name'      => esc($this->request->getPost('name')),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'      => $this->request->getPost('role'),
            'api_token' => bin2hex(random_bytes(32)),
        ]);

        return redirect()->to('/users')->with('success', 'User created successfully.');
    }

    public function edit($id): string
    {
        $user = $this->model->find($id);
        if (! $user) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return $this->render('users/form', compact('user'));
    }

    public function update($id)
    {
        $rules = [
            'name'  => 'required|min_length[2]|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role'  => 'required|in_list[superadmin,manager,staff]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'  => esc($this->request->getPost('name')),
            'email' => $this->request->getPost('email'),
            'role'  => $this->request->getPost('role'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }

        $this->model->update($id, $data);
        return redirect()->to('/users')->with('success', 'User updated successfully.');
    }

    public function delete($id)
    {
        if ($id == session()->get('user_id')) {
            return redirect()->back()->with('error', 'Cannot delete yourself.');
        }
        $this->model->delete($id);
        return redirect()->to('/users')->with('success', 'User deleted.');
    }
}
