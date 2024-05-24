<?php

namespace App\Controllers;

use App\Models\RoleModel;
use CodeIgniter\Controller;

class RoleController extends Controller
{
    public function index()
    {
        $model = new RoleModel();
        $data['roles'] = $model->findAll();
        return view('roles/roles_view', $data);
    }

    public function create()
    {
        return view('roles/roles_view');
    }

    public function store()
    {
        $model = new RoleModel();
        $data = [
            'Role_Name' => $this->request->getPost('Role_Name'),
            'Description' => $this->request->getPost('Description')
        ];
        $model->save($data);
        return redirect()->to('/roles');
    }

    public function edit($id)
    {
        $model = new RoleModel();
        $data['role'] = $model->find($id);
        return view('roles/roles_view', $data);
    }

    public function update($id)
    {
        $model = new RoleModel();
        $data = [
            'Role_Name' => $this->request->getPost('Role_Name'),
            'Description' => $this->request->getPost('Description')
        ];
        $model->update($id, $data);
        return redirect()->to('/roles');
    }

    public function delete($id)
    {
        $model = new RoleModel();
        $model->delete($id);
        return redirect()->to('/roles');
    }
}
