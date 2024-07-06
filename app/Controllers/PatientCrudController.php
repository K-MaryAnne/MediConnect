<?php

namespace App\Controllers;

use App\Models\User_model;

class PatientCrudController extends BaseController
{
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


    // Display list of patients

    public function view_patients() {
        $data['patients'] = $this->userModel->get_all_patients();
        echo view('patients_view', $data);
    }

    // Add new patients
    public function add() {
        // Handle form submission to insert admin
    }
    
    //Edit patients
    // public function edit_patient($id) {
    //     $patient = $this->userModel->get_patient_by_id($id);
    //     if (!$patient) {
    //         return redirect()->back()->with('error', 'patient not found');
    //     }

    //     $data['patient'] = $patient;
    //     echo view('edit_patient_view', $data);
    // }

    public function edit_patient($id) {
        $patient = $this->userModel->get_patient_by_id($id);
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found');
        }
    
        $data['patient'] = $patient;
        return view('edit_patient_view', $data);
    }
    

    // Update patient
    // public function update_patient($id) {
    //     if ($this->request->getMethod() == 'post') {
    //         $validation =  \Config\Services::validation();

    //         $validation->setRules([
    //             'First_Name' => 'required|min_length[3]|max_length[50]',
    //             'Last_Name' => 'required|min_length[3]|max_length[50]',
    //             'Specialisation' => 'required|min_length[3]|max_length[100]',
    //             'Years_of_Experience' => 'required|integer',
    //             'Email' => 'required|valid_email',
    //             'status' => 'required|in_list[active,inactive]',
    //         ]);

    //         if (!$validation->withRequest($this->request)->run()) {
    //             return redirect()->back()->with('error', $validation->listErrors());
    //         }

    //         $data = [
    //             'First_Name' => $this->request->getPost('First_Name'),
    //             'Last_Name' => $this->request->getPost('Last_Name'),
    //             'Specialisation' => $this->request->getPost('Specialisation'),
    //             'Years_of_Experience' => $this->request->getPost('Years_of_Experience'),
    //             'Email' => $this->request->getPost('Email'),
    //             'status' => $this->request->getPost('status')
    //         ];

    //         if ($this->userModel->update_patient($id, $data)) {
    //             return redirect()->to('/view_patients')->with('success', 'Patient updated successfully');
    //         } else {
    //             return redirect()->back()->with('error', 'Failed to update patient');
    //         }
    //     }
    // }
    public function update_patient($id)
    {
        helper(['form', 'url']);
    
        // Validation rules for patient update form
        $validationRules = [
            'First_Name' => 'required|min_length[3]|max_length[50]',
            'Last_Name' => 'required|min_length[3]|max_length[50]',
            'Email' => 'required|valid_email',
            'status' => 'required|in_list[active,inactive]',
        ];
    
        // Validate input against the rules
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
    
        $userModel = new User_model(); // Assuming your model is named User_model
        $data = [
            'First_Name' => $this->request->getVar('First_Name'),
            'Last_Name' => $this->request->getVar('Last_Name'),
            'Email' => $this->request->getVar('Email'),
            'status' => $this->request->getVar('status'),
        ];
    
        // Update patient data in the database
        if ($userModel->update_patient($id, $data)) {
            return redirect()->to('/view-patients')->with('success', 'Patient updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update patient');
        }
    }
    
    
    
    


    //Delete patient
    public function delete_patient($id) {
        if ($this->userModel->delete_patient($id)) {
            return redirect()->to('/view_patients')->with('success', 'Patient deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete patient');
        }
    }

    

    // Profile view and update
    public function profile($id) {
        $patient = $this->userModel->find($id);
        echo view('patient_profile', ['patient' => $patient]);
    }

    public function update_profile($id) {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'first_name' => 'required|min_length[3]|max_length[50]',
                'last_name' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email',
                'mobile_number' => 'required|min_length[10]|max_length[15]',
                'profile_image' => 'is_image[profile_image]|max_size[profile_image,1024]|mime_in[profile_image,image/jpg,image/jpeg,image/png]',
                'rating' => 'required|in_list[1,2,3,4,5]',
                'review' => 'required|min_length[5]|max_length[255]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'First_Name' => $this->request->getPost('first_name'),
                    'Last_Name' => $this->request->getPost('last_name'),
                    'Email' => $this->request->getPost('email'),
                    'Mobile_Number' => $this->request->getPost('mobile_number'),
                    'Rating' => $this->request->getPost('rating'),
                    'Review' => $this->request->getPost('review'),
                ];

                $profileImage = $this->request->getFile('profile_image');
                if ($profileImage->isValid() && !$profileImage->hasMoved()) {
                    $newName = $profileImage->getRandomName();
                    $profileImage->move(WRITEPATH . 'uploads');
                    $data['Profile_Image'] = $profileImage->getName();
                }

                $this->userModel->update($id, $data);
                return redirect()->to('/PatientCrudController/profile/' . $id)->with('success', 'Profile updated successfully');
            } else {
                return redirect()->to('/PatientCrudController/profile/' . $id)->withInput()->with('errors', $this->validator->getErrors());
            }
        }
    }
}
