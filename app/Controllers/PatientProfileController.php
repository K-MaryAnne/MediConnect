<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AppointmentModel;

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
            // Validate input data
            $rules = [
                'name' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email',
                'secondary_email' => 'permit_empty|valid_email',
                'address' => 'permit_empty|max_length[255]',
                'password' => 'permit_empty|min_length[8]',
                'profile_photo' => [
                    'uploaded[profile_photo]',
                    'max_size[profile_photo,1024]',
                    'is_image[profile_photo]',
                    'mime_in[profile_photo,image/jpg,image/jpeg,image/png,image/gif]'
                ]
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

                // Handle profile photo upload if provided
                if ($profilePhoto = $this->request->getFile('profile_photo')) {
                    // Validate and process profile photo upload
                    if ($profilePhoto->isValid() && !$profilePhoto->hasMoved()) {
                        $newName = $profilePhoto->getRandomName();
                        $profilePhoto->move(ROOTPATH . 'public/imgs', $newName);
                        $data['profile_photo'] = 'imgs/' . $newName;
                    } else {
                        return redirect()->back()->withInput()->with('error', 'Failed to upload profile photo.');
                    }
                }

                // Update user's profile
                if ($userModel->update($userId, $data)) {
                    return redirect()->to('/profile')->with('success', 'Profile updated successfully.');
                } else {
                    return redirect()->to('/profile')->with('error', 'Failed to update profile.');
                }
            } else {
                return redirect()->back()->withInput()->with('validation', $this->validator);
            }
        }

        return view('profile_edit', ['user' => $user]);
    }
 
    public function rateDoctor($doctorId)
{
    $session = session();
    $userId = $session->get('user_id');

    if (!$userId) {
        return redirect()->to('/login')->with('error', 'Please log in to rate a doctor.');
    }

    $ratingModel = new RatingModel();

    if ($this->request->getMethod() === 'post') {
        if ($this->validate([
            'rating' => 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[5]',
            'review' => 'permit_empty|max_length[255]'
        ])) {
            $data = [
                'user_id' => $userId,
                'doctor_id' => $doctorId,
                'rating' => $this->request->getPost('rating'),
                'review' => $this->request->getPost('review')
            ];

            if ($ratingModel->insert($data)) {
                return redirect()->back()->with('success', 'Rating and review submitted successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to submit rating and review.');
            }
        } else {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }
    }
}

        public function dashboard()
        {
            $session = session();
            $userId = $session->get('user_id');
    
            if (!$userId) {
                return redirect()->to('/login')->with('error', 'Please log in to view your dashboard.');
            }
    
            $userModel = new UserModel();
            $appointmentModel = new AppointmentModel();
            $doctorModel = new DoctorModel();
    
            $user = $userModel->find($userId);
            $appointments = $appointmentModel->where('patient_id', $userId)->findAll();
            $doctors = $doctorModel->findAll();
    
            return view('patient_dashboard', [
                'user' => $user,
                'appointments' => $appointments,
                'doctors' => $doctors,
            ]);
        }
    
        private function renderDoctorConfirmationEmail($data)
        {
            // Load the email template view for doctor's confirmation and pass data to it
            $emailContent = view('emails/doctor_verification_email', $data);
            return $emailContent;
        }
    
        public function bookAppointment()
        {
            $session = session();
            $userId = $session->get('user_id');
    
            if (!$userId) {
                return redirect()->to('/login')->with('error', 'Please log in to book an appointment.');
            }
    
            if ($this->request->getMethod() === 'post') {
                $appointmentModel = new AppointmentModel();
    
                $data = [
                    'patient_id' => $userId,
                    'doctor_id' => $this->request->getPost('doctor_id'),
                    'date' => $this->request->getPost('date'),
                    'time' => $this->request->getPost('time'),
                ];
    
                if ($appointmentModel->insert($data)) {
                    // Send confirmation email
                    $email = \Config\Services::email();
                    $email->setTo($session->get('email'));
                    $email->setSubject('Appointment Confirmation');
                    $email->setMessage('Your appointment has been confirmed for ' . $data['date'] . ' at ' . $data['time'] . ' with Dr. ' . $data['doctor_id']);
                    $email->send();
    
                    // Add to calendar functionality (not implemented here)
    
                    return redirect()->to('/patient-profile/dashboard')->with('success', 'Appointment booked successfully.');
                } else {
                    return redirect()->to('/patient-profile/dashboard')->with('error', 'Failed to book appointment.');
                }
            }
        }
    
}
