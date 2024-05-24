<?php

namespace App\Controllers;

use App\Models\NurseModel;
use CodeIgniter\Controller;

class NurseController extends Controller
{
    public function index()
    {
        $model = new NurseModel();
        $data['nurses'] = $model->findAll();
        return view('nurse/index', $data);
    }

    public function create()
    {
        return view('nurse/create');
    }

    public function store()
    {
        $model = new NurseModel();
        $data = [
            'User_ID' => $this->request->getPost('User_ID'),
            'Role_ID' => $this->request->getPost('Role_ID'),
            'First Name' => $this->request->getPost('First Name'),
            'Last Name' => $this->request->getPost('Last Name'),
            'Years of Experience' => $this->request->getPost('Years of Experience'),
            'Rating' => $this->request->getPost('Rating'),
        ];
        $model->save($data);
        return redirect()->to('/nurse');
    }

    public function edit($id)
    {
        $model = new NurseModel();
        $data['nurse'] = $model->find($id);
        return view('nurse/edit', $data);
    }

    public function update($id)
    {
        $model = new NurseModel();
        $data = [
            'User_ID' => $id, 
            'Role_ID' => $this->request->getPost('Role_ID'),
            'First Name' => $this->request->getPost('First Name'),
            'Last Name' => $this->request->getPost('Last Name'),
            'Years of Experience' => $this->request->getPost('Years of Experience'),
            'Rating' => $this->request->getPost('Rating'),
        ];
        $model->update($id, $data);
        return redirect()->to('/nurse');
    }

    public function delete($id)
    {
        $model = new NurseModel();
        $model->delete($id);
        return redirect()->to('/nurse');
    }
}
