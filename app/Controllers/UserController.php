<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->findAll();
        return view('users/index', $data);
    }

    public function create()
    {
        return view('users/create');
    }

    public function store()
    {
        $model = new UserModel();
        $data = [
            'User_id' => $this->request->getPost('User_id'),
            'First Name' => $this->request->getPost('First Name'),
            'Last Name' => $this->request->getPost('Last Name'),
            'Other Names' => $this->request->getPost('Other Names'),
            'E-mail' => $this->request->getPost('E-mail'),
            'Phone Number' => $this->request->getPost('Phone Number'),
            'Gender' => $this->request->getPost('Gender'),
            'Age' => $this->request->getPost('Age'),
            'Password' => password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT),
        ];
        $model->save($data);
        return redirect()->to('/users');
    }

    public function edit($id)
    {
        $model = new UserModel();
        $data['user'] = $model->find($id);
        return view('users/edit', $data);
    }

    public function update($id)
    {
        $model = new UserModel();
        $data = [
            'User_id' => $this->request->getPost('User_id'),
            'First Name' => $this->request->getPost('First Name'),
            'Last Name' => $this->request->getPost('Last Name'),
            'Other Names' => $this->request->getPost('Other Names'),
            'E-mail' => $this->request->getPost('E-mail'),
            'Phone Number' => $this->request->getPost('Phone Number'),
            'Gender' => $this->request->getPost('Gender'),
            'Age' => $this->request->getPost('Age'),
            'Password' => password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT),
        ];
        $model->update($id, $data);
        return redirect()->to('/users');
    }

    public function delete($id)
    {
        $model = new UserModel();
        $model->delete($id);
        return redirect()->to('/users');
    }
}
