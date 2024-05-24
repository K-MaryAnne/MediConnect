<?php

namespace App\Controllers;

use App\Models\DoctorModel;
use CodeIgniter\Controller;

class DoctorController extends Controller
{
    public function index()
    {
        $model = new DoctorModel();
        $data['doctors'] = $model->findAll();
        return view('doctors/index', $data);
    }

    public function create()
    {
        return view('doctors/create');
    }

    public function store()
    {
        $model = new DoctorModel();
        $data = [
            'User_ID' => $this->request->getPost('User_ID'),
            'Role_ID' => $this->request->getPost('Role_ID'),
            'First Name' => $this->request->getPost('First Name'),
            'Last Name' => $this->request->getPost('Last Name'),
            'Specialisation' => $this->request->getPost('Specialisation'),
            'Years of Experience' => $this->request->getPost('Years of Experience'),
            'Rating' => $this->request->getPost('Rating'),
        ];
        $model->save($data);
        return redirect()->to('/doctors');
    }

    public function edit($id)
    {
        $model = new DoctorModel();
        $data['doctor'] = $model->find($id);
        return view('doctors/edit', $data);
    }

    public function update($id)
    {
        $model = new DoctorModel();
        $data = [
            'Role_ID' => $this->request->getPost('Role_ID'),
            'First Name' => $this->request->getPost('First Name'),
            'Last Name' => $this->request->getPost('Last Name'),
            'Specialisation' => $this->request->getPost('Specialisation'),
            'Years of Experience' => $this->request->getPost('Years of Experience'),
            'Rating' => $this->request->getPost('Rating'),
        ];
        $model->update($id, $data);
        return redirect()->to('/doctors');
    }

    public function delete($id)
    {
        $model = new DoctorModel();
        $model->delete($id);
        return redirect()->to('/doctors');
    }
}

