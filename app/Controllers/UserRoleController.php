<?php

namespace App\Controllers;

use App\Models\UserRoleModel;
use CodeIgniter\Controller;

class UserRoleController extends Controller
{
    public function index()
    {
        $model = new UserRoleModel();
        $data['user_roles'] = $model->findAll();
        return view('user_roles/index', $data);
    }

    public function create()
    {
        return view('user_roles/create');
    }

    public function store()
    {
        $model = new UserRoleModel();
        $data = [
            'User_ID' => $this->request->getPost('User_ID'),
            'Role_ID' => $this->request->getPost('Role_ID'),
            'Assigned at' => $this->request->getPost('Assigned at'),
        ];
        $model->save($data);
        return redirect()->to('/user_roles');
    }

    public function edit($id)
    {
        $model = new UserRoleModel();
        $data['user_role'] = $model->find($id);
        return view('user_roles/edit', $data);
    }

    public function update($id)
    {
        $model = new UserRoleModel();
        $data = [
            'User_ID' => $this->request->getPost('User_ID'),
            'Role_ID' => $this->request->getPost('Role_ID'),
            'Assigned at' => $this->request->getPost('Assigned at'),
        ];
        $model->update($id, $data);
        return redirect()->to('/user_roles');
    }

    public function delete($id)
    {
        $model = new UserRoleModel();
        $model->delete($id);
        return redirect()->to('/user_roles');
    }
}
