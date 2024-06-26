<?php

namespace App\Controllers;
use App\Models\UserModel;

class PatientProfileController extends BaseController
{
    public function index()
    {
        return view('patient_profile');
    }
    public function profile()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please log in to view your profile.');
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        echo view('patient_profile', ['user' => $user]);
    }

    public function editProfile()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please log in to edit your profile.');
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email',
                'secondary_email' => 'permit_empty|valid_email',
                'address' => 'permit_empty|max_length[255]',
                'password' => 'permit_empty|min_length[8]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'secondary_email' => $this->request->getPost('secondary_email'),
                    'address' => $this->request->getPost('address'),
                    // Hash password if changed
                    'password' => $this->request->getPost('password') ? password_hash($this->request->getPost('password'), PASSWORD_DEFAULT) : $user['password']
                ];

                if ($userModel->update($userId, $data)) {
                    return redirect()->to('/patient_profile')->with('success', 'Profile updated successfully.');
                } else {
                    return redirect()->to('/patient_profile')->with('error', 'Failed to update profile.');
                }
            } else {
                return redirect()->to('/patient_profile')->withInput()->with('validation', $this->validator);
            }
        }

        echo view('profile_edit', ['user' => $user]);
    }

    public function uploadPhoto()
    {
        helper(['form', 'url']);

        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please log in to upload a photo.');
        }

        $userModel = new UserModel();

        if ($this->request->getMethod() === 'post') {
            if ($this->validate([
                'profile_photo' => [
                    'uploaded[profile_photo]',
                    'max_size[profile_photo,1024]',
                    'is_image[profile_photo]',
                    'mime_in[profile_photo,image/jpg,image/jpeg,image/png,image/gif]'
                ]
            ])) {
                $photo = $this->request->getFile('profile_photo');
                $newName = $photo->getRandomName();
                $photo->move(WRITEPATH . 'uploads/images', $newName);

                $data = ['profile_photo' => '/uploads/images/' . $newName];

                if ($userModel->update($userId, $data)) {
                    return redirect()->to('/patient_profile')->with('success', 'Profile photo updated successfully.');
                } else {
                    return redirect()->to('/patient_profile')->with('error', 'Failed to update profile photo.');
                }
            } else {
                return redirect()->to('/patient_profile')->with('error', $this->validator->listErrors());
            }
        }
    }
}
