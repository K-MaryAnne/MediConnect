<?php

namespace App\Controllers;

use App\Models\PatientModel;
use CodeIgniter\Controller;

class  PatientController extends Controller
{
    public function index()
    {
        $model = new PatientModel();
        $data['patient'] = $model->findAll();
        return view('patient/index', $data);
    }

    public function create()
    {
        return view('patient/create');
    }

    public function store()
    {
        $model = new PatientModel();
        $data = [
            'User_ID' => $this->request->getPost('User_ID'),
            'Role_ID' => $this->request->getPost('Role_ID'),
            'First Name' => $this->request->getPost('First Name'),
            'Last Name' => $this->request->getPost('Last Name'),
        ];
        $model->save($data);
        return redirect()->to('/patient');
    }

    public function edit($id)
    {
        $model = new PatientModel();
        $data['patient'] = $model->find($id);
        return view('patient/edit', $data);
    }

    public function update($id)
    {
        $model = new PatientModel();
        $data = [
            'User_ID' => $this->request->getPost('User_ID'),
            'Role_ID' => $this->request->getPost('Role_ID'),
            'First Name' => $this->request->getPost('First Name'),
            'Last Name' => $this->request->getPost('Last Name'),
        ];
        $model->update($id, $data);
        return redirect()->to('/patient');
    }

    public function delete($id)
    {
        $model = new PatientModel();
        $model->delete($id);
        return redirect()->to('/patient');
    }
}

