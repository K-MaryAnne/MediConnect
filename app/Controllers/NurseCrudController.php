<?php

namespace App\Controllers;

use App\Models\User_model;

class NurseCrudController extends BaseController
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


    // Display list of nurses

    public function view_nurses() {
        $data['nurses'] = $this->userModel->get_all_nurses();
        echo view('nurses_view', $data);
    }

    // Add new nurses
    public function add() {
        // Handle form submission to insert admin
    }
    
    //Edit nurses
    // public function edit_nurse($id) {
    //     $nurse = $this->userModel->get_nurse_by_id($id);
    //     if (!$nurse) {
    //         return redirect()->back()->with('error', 'Nurse not found');
    //     }

    //     $data['nurse'] = $nurse;
    //     echo view('edit_nurse_view', $data);
    // }

    public function edit_nurse($id) {
        $nurse = $this->userModel->get_nurse_by_id($id);
        if (!$nurse) {
            return redirect()->back()->with('error', 'Nurse not found');
        }
    
        $data['nurse'] = $nurse;
        return view('edit_nurse_view', $data);
    }
    

    // Update nurse
    // public function update_nurse($id) {
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

    //         if ($this->userModel->update_nurse($id, $data)) {
    //             return redirect()->to('/view_nurses')->with('success', 'nurse updated successfully');
    //         } else {
    //             return redirect()->back()->with('error', 'Failed to update nurse');
    //         }
    //     }
    // }
    public function update_nurse($id)
    {
        helper(['form', 'url']);
    
        // Validation rules for nurse update form
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
    
        // Update nurse data in the database
        if ($userModel->update_nurse($id, $data)) {
            return redirect()->to('/view-nurses')->with('success', 'Nurse updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update nurse');
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

    
       

    // Profile view and update
    public function profile($id) {
        $nurse = $this->userModel->find($id);
        echo view('nurse_profile', ['nurse' => $nurse]);
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
                return redirect()->to('/NurseCrudController/profile/' . $id)->with('success', 'Profile updated successfully');
            } else {
                return redirect()->to('/NurseCrudController/profile/' . $id)->withInput()->with('errors', $this->validator->getErrors());
            }
        }
    }
}
