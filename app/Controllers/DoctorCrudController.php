<?php

namespace App\Controllers;

use App\Models\User_model;

class DoctorCrudController extends BaseController
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


    // Display list of doctors

    public function view_doctors() {
        $data['doctors'] = $this->userModel->get_all_doctors();
        echo view('doctors_view', $data);
    }

    // Add new doctors
    public function add() {
        // Handle form submission to insert admin
    }
    
    //Edit doctors
    public function edit_doctor($id) {
        $doctor = $this->userModel->get_doctor_by_id($id);
        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor not found');
        }

        $data['doctor'] = $doctor;
        echo view('edit_doctor_view', $data);
    }

    // Update doctor
    public function update_doctor($id) {
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

            if ($this->userModel->update_doctor($id, $data)) {
                return redirect()->to('/view_doctors')->with('success', 'Doctor updated successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to update doctor');
            }
        }
    }


    //Delete doctor
    public function delete_doctor($id) {
        if ($this->userModel->delete_doctor($id)) {
            return redirect()->to('/view_doctors')->with('success', 'Doctor deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete doctor');
        }
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
                return redirect()->to('/DoctorCrudController/profile/' . $id)->with('success', 'Profile updated successfully');
            } else {
                return redirect()->to('/DoctorCrudController/profile/' . $id)->withInput()->with('errors', $this->validator->getErrors());
            }
        }
    }
}
