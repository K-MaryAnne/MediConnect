<?php

namespace App\Controllers;

use App\Models\User_model;

class DoctorCrudController extends BaseController
{
    public function __construct() {
        $this->userModel = new User_model();
        $this->db = \Config\Database::connect();
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
    // public function edit_doctor($id) {
    //     $doctor = $this->userModel->get_doctor_by_id($id);
    //     if (!$doctor) {
    //         return redirect()->back()->with('error', 'Doctor not found');
    //     }

    //     $data['doctor'] = $doctor;
    //     echo view('edit_doctor_view', $data);
    // }

    public function edit_doctor($id) {
        $doctor = $this->userModel->get_doctor_by_id($id);
        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor not found');
        }
    
        $data['doctor'] = $doctor;
        return view('edit_doctor_view', $data);
    }
    

    // Update doctor
    // public function update_doctor($id) {
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

    //         if ($this->userModel->update_doctor($id, $data)) {
    //             return redirect()->to('/view_doctors')->with('success', 'Doctor updated successfully');
    //         } else {
    //             return redirect()->back()->with('error', 'Failed to update doctor');
    //         }
    //     }
    // }
    public function update_doctor($id)
    {
        helper(['form', 'url']);
    
        // Validation rules for doctor update form
        $validationRules = [
            'First_Name' => 'required|min_length[3]|max_length[50]',
            'Last_Name' => 'required|min_length[3]|max_length[50]',
            'Specialisation' => 'required|min_length[3]|max_length[100]',
            'Years_of_Experience' => 'required|integer',
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
            'Specialisation' => $this->request->getVar('Specialisation'),
            'Years_of_Experience' => $this->request->getVar('Years_of_Experience'),
            'Email' => $this->request->getVar('Email'),
            'status' => $this->request->getVar('status'),
        ];
    
        // Update doctor data in the database
        if ($userModel->update_doctor($id, $data)) {
            return redirect()->to('/view-doctors')->with('success', 'Doctor updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update doctor');
        }
    }
    
    
    
    


    // Suspend doctor
public function suspend_doctor($id) {
    if ($this->userModel->suspend_doctor($id)) {
        return redirect()->to('/view_doctors')->with('success', 'Doctor suspended successfully');
    } else {
        return redirect()->back()->with('error', 'Failed to suspend doctor');
    }
}

public function view_suspended_doctors() {
    $data['suspended_doctors'] = $this->userModel->getSuspendedDoctors();
    echo view('suspend_doctors_view', $data);
}

public function restore_doctor($id) {
    if ($this->userModel->restoreDoctor($id)) {
        return redirect()->to(base_url('view-suspended-doctors'))->with('success', 'Doctor restored successfully');
    } else {
        return redirect()->to(base_url('view-suspended-doctors'))->with('error', 'Failed to restore doctor');
    }
}

    // View Patients
    public function view_patients() {
        $data['patients'] = $this->userModel->get_all_patients();
        echo view('patients_view', $data);
    }

    // View User Applications
    // public function applications_view() {
    //     $data['applications'] = $this->userModel->get_pending_applications();
    //     return view('applications_view', $data);
    // }

    public function applications_view() {
        $db = db_connect();
        $query = $db->query("SELECT * FROM user_applications WHERE status = 'pending'");
        $data['applications'] = $query->getResult();
        return view('applications_view', $data);
    }
    
    // Accept application
    public function accept_application($application_id) {
        // $this->db->transStart();

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

            // Update role in the users table
        $this->userModel->update_user_role($application->User_ID, $data['Role_ID']);
            
            // Update application status to 'accepted'
            $this->userModel->update_application_status($application_id, 'accepted');
            
        } else {
            log_message('error', 'Application not found: ID ' . $application_id);
        }

        // if ($this->db->transStatus() === FALSE) {
        //     // If something went wrong, roll back the transaction
        //     return redirect()->back()->with('error', 'Failed to process application');
        // }
        
        return redirect()->to('/DoctorCrudController/applications_view')->with('success', 'Application accepted successfully');
    }
    
    // Deny application
public function deny_application($application_id) {
    $application = $this->userModel->get_application_by_id($application_id);

    if ($application) {
        // Prepare data for insertion into denied_applications table
        $data = [
          'User_ID' => $application->User_ID,
                'First_Name' => $application->first_name,
                'Last_Name' => $application->last_name,
                'Specialisation' => $application->Specialisation,
                'Years_of_Experience' => $application->Years_of_Experience
                
        ];

        // Update application status to 'denied'
        $this->userModel->update_application_status($application_id, 'denied');

        // Insert into denied_applications table
        $inserted = $this->userModel->insert_denied_application($data);

        if ($inserted) {
            return redirect()->to('/DoctorCrudController/applications_view')->with('success', 'Application denied successfully');
        } else {
            // Handle insertion failure (optional)
            return redirect()->back()->with('error', 'Failed to deny application. Please try again.');
        }
    } else {
        // Handle application not found (optional)
        return redirect()->back()->with('error', 'Application not found.');
    }
}


    // Manage Users (example view)
    public function manage_users() {
        echo view('manage_users');
    }


    public function search()
    {
        $query = $this->request->getGet('query');
        $results = $this->userModel->searchDoctor($query);
        
        return view('doctor_search_results', ['results' => $results]);
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
