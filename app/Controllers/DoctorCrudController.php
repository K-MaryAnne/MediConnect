<?php

namespace App\Controllers;

use App\Models\User_model;

class DoctorCrudController extends BaseController
{
    protected $userModel;

    public function __construct() {
        $this->userModel = new User_model();
    }

    // Display list of doctors
    public function view_doctors() {
        $data['doctors'] = $this->userModel->get_all_doctors();
        echo view('doctors_view', $data);
    }

    // Add new doctors
    public function add() {
        // Handle form submission to insert admin
    }
    
    // Edit doctor
    public function edit($id) {
        // Handle form submission to update admin
    }
    
    // Delete doctor
    public function delete($id) {
        // Handle deletion of admin
    }

    // View Patients
    public function view_patients() {
        $data['patients'] = $this->userModel->get_all_patients();
        echo view('patients_view', $data);
    }

    // View User Applications
    public function applications_view() {
        $data['applications'] = $this->userModel->get_all_applications();
        return view('applications_view', $data);
    }
    
    // Accept application
    public function accept_application($application_id) {
        $application = $this->userModel->get_application_by_id($application_id);
        
        if ($application) {
            $data = [
                'User_ID' => $application->User_ID,
                'First_Name' => $application->first_name,
                'Last_Name' => $application->last_name,
                'Specialisation' => $application->Specialisation,
                'Years_of_Experience' => $application->Years_of_Experience,
                'Rating' => 0,
                'status' => 'active'
            ];
            
            if ($application->role_applied_for == 'Doctor') {
                $data['Role_ID'] = 2; // Assuming 2 is the Role_ID for doctors
                $this->userModel->insert_doctor($data);
            } elseif ($application->role_applied_for == 'Nurse') {
                $data['Role_ID'] = 3; // Assuming 3 is the Role_ID for nurses
                $this->userModel->insert_nurse($data);
            }
            
            // Update application status to 'accepted'
            $this->userModel->update_application_status($application_id, 'accepted');
        } else {
            log_message('error', 'Application not found: ID ' . $application_id);
        }
        
        return redirect()->to('/DoctorCrudController/applications_view');
    }
    
    // Deny application
    public function deny_application($application_id) {
        $this->userModel->update_application_status($application_id, 'denied');
        return redirect()->to('/DoctorCrudController/applications_view');
    }

    // Manage Users (example view)
    public function manage_users() {
        echo view('manage_users');
    }

    // Profile view and update
    public function profile($id) {
        $doctor = $this->userModel->find($id);
        echo view('doctor_profile', ['doctor' => $doctor]);
    }

    public function update_profile($id) {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'first_name' => 'required|min_length[3]|max_length[50]',
                'last_name' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email',
                'mobile_number' => 'required|min_length[10]|max_length[15]',
                'profile_image' => 'is_image[profile_image]|max_size[profile_image,1024]|mime_in[profile_image,image/jpg,image/jpeg,image/png]'
            ];

            if ($this->validate($rules)) {
                $data = [
                    'First_Name' => $this->request->getPost('first_name'),
                    'Last_Name' => $this->request->getPost('last_name'),
                    'Email' => $this->request->getPost('email'),
                    'Mobile_Number' => $this->request->getPost('mobile_number'),
                ];

                $profileImage = $this->request->getFile('profile_image');
                if ($profileImage->isValid() && !$profileImage->hasMoved()) {
                    $profileImage->move(WRITEPATH . 'uploads');
                    $data['Profile_Image'] = $profileImage->getName();
                }

                $this->userModel->update($id, $data);
                return redirect()->to('/DoctorCrudController/profile/' . $id)->with('success', 'Profile updated successfully');
            } else {
                return redirect()->to('/DoctorCrudController/profile/' . $id)->withInput()->with('errors', $this->validator->getErrors());
            }
        }
    }
}
