<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use GuzzleHttp\Client;

class Auth extends Controller
{
    public function register()
    {
        helper(['form', 'url']);

        $model = new UserModel();

        if ($this->request->getMethod() === 'post') {
            // Validation rules for registration form fields
            $validationRules = [
                'full-name' => 'required',
                'your-email' => 'required|valid_email|is_unique[users.E-mail]',
                'password' => 'required|min_length[8]'
            ];

            if (!$this->validate($validationRules)) {
                return view('register', ['validation' => $this->validator]);
            }

            // Generate activation code
            $activationCode = bin2hex(random_bytes(16));

            // Insert user data into database
            $userData = [
                'First Name' => $this->request->getPost('full-name'),
                'E-mail' => $this->request->getPost('your-email'),
                'Password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'activation_code' => $activationCode
            ];
            $model->insert($userData);

            // Send activation email
            $this->sendActivationEmail($userData['E-mail'], $userData['First Name'], $activationCode);

            return redirect()->to('login')->with('success', 'Registration successful. Please check your email to activate your account.');
        }

        return view('register');
    }

    private function sendActivationEmail($email, $name, $activationCode)
    {
        $client = new Client([
            'base_uri' => 'https://api.mailgun.net/v3/',
            'timeout'  => 2.0,
        ]);

        $domain = 'your-mailgun-domain.com';
        $apiKey = 'your-mailgun-api-key';

        try {
            $response = $client->request('POST', "{$domain}/messages", [
                'auth' => ['api', $apiKey],
                'form_params' => [
                    'from'    => 'MediConnect <no-reply@your-mailgun-domain.com>',
                    'to'      => $email,
                    'subject' => 'Activate Your Account',
                    'html'    => 'Click the link to activate your account: ' . site_url('auth/activate/' . $activationCode),
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new Exception('Failed to send email.');
            }
        } catch (Exception $e) {
            // Handle email sending errors
            log_message('error', 'Email sending failed: ' . $e->getMessage());
        }
    }

    public function activate($code)
    {
        $model = new UserModel();
        $user = $model->verifyActivationCode($code);

        if ($user) {
            $model->update($user['User_id'], ['is_active' => 1, 'activation_code' => null]);
            return view('message_view', [
                'title' => 'Account Activated',
                'message' => 'Your account has been activated. You can now log in.'
            ]);
        }

        return view('message_view', [
            'title' => 'Activation Failed',
            'message' => 'Invalid activation code. Please check your email and try again.',
            'link' => site_url('register')
        ]);
    }

    public function completeProfile()
    {
        helper(['form', 'url']);
        $model = new UserModel();

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'address' => 'required',
                'phone' => 'required|numeric',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return view('complete_profile', ['validation' => $validation]);
            }

            $userId = session()->get('user_id'); // Assuming user ID is stored in session after activation
            $profileData = [
                'address' => $this->request->getVar('address'),
                'phone' => $this->request->getVar('phone'),
            ];

            $model->update($userId, $profileData);

            return view('message_view', [
                'message_type' => 'profile_completed'
            ]);
        }

        return view('complete_profile');
    }
}
