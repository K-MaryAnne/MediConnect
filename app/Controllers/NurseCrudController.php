<?php

namespace App\Controllers;

use App\Models\User_model;

class NurseCrudController extends BaseController
{
    // protected $userModel;

    // public function __construct() {
    //     $this->userModel = new User_model();
    // }
    

    public function __construct() {
        $this->userModel = new User_model();
        helper(['form', 'url']);
    
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
    
        // Check if user has the right role/permissions
        // Assuming role 1 is admin
        if (session()->get('role') != 1) {
            return redirect()->to('/unauthorized');
        }
    }
    
    
    // View Nurses
    public function view_nurses() {
        $data['nurses'] = $this->userModel->get_all_nurses();
        echo view('nurses_view', $data);
    }
    // Add new nurses
    public function add() {
        // Handle form submission to insert admin
    }
    
           
     //Edit nurse
     public function edit_nurse($id) {
        $nurse = $this->userModel->get_nurse_by_id($id);
        if (!$nurse) {
            return redirect()->back()->with('error', 'Nurse not found');
        }

        $data['nurse'] = $nurse;
        echo view('edit_nurse_view', $data);
    }

    // Update nurse
    public function update_nurse($id) {
        if ($this->request->getMethod() == 'post') {
            $validation =  \Config\Services::validation();

            $validation->setRules([
                'First_Name' => 'required|min_length[3]|max_length[50]',
                'Last_Name' => 'required|min_length[3]|max_length[50]',
                'Specialisation' => 'required|min_length[3]|max_length[100]',
                'Years_of_Experience' => 'required|integer',
                'Email' => 'required|valid_email',
                'status' => 'required|in_list[active,inactive]',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->with('error', $validation->listErrors());
            }

            $data = [
                'First_Name' => $this->request->getPost('First_Name'),
                'Last_Name' => $this->request->getPost('Last_Name'),
                'Specialisation' => $this->request->getPost('Specialisation'),
                'Years_of_Experience' => $this->request->getPost('Years_of_Experience'),
                'Email' => $this->request->getPost('Email'),
                'status' => $this->request->getPost('status')
            ];

            if ($this->userModel->update_nurse($id, $data)) {
                return redirect()->to('/view_nurses')->with('success', 'Nurse updated successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to update nurse');
            }
        }
    }
    


    //Delete nurse
    public function delete_nurse($id) {
        if ($this->userModel->delete_nurse($id)) {
            return redirect()->to('/view_nurses')->with('success', 'Nurse deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete nurse');
        }
    }
}
