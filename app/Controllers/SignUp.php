<?php

namespace App\Controllers;

use App\Models\UserModel;

class SignUp extends BaseController
{
    public function index()
    {
        $data['title'] = 'Sign Up';
        return view('sign_up', $data);
    }

    public function register()
    {
        $data = $this->request->getPost();
        $model = new UserModel();
        $data['Password'] = password_hash($data['Password'], PASSWORD_DEFAULT);
        $data['Verification_Token'] = bin2hex(random_bytes(16));

        if ($model->save($data)) {
            $this->sendVerificationEmail($data['Email'], $data['Verification_Token']);
            return redirect()->to('/login')->with('success', 'Registration successful. Please check your email to activate your account.');
        } else {
            return redirect()->back()->with('error', 'Registration failed. Please try again.');
        }
    }

    public function loginForm()
    {
        $data['title'] = 'Login';
        return view('login', $data);
    }

    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user = $model->where('Email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['Password'])) {
                if ($user['Status'] == 1) {
                    $this->setUserSession($user);
                    return redirect()->to('/dashboard');
                } else {
                    return redirect()->back()->with('error', 'Your account is not activated. Please check your email.');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid password');
            }
        } else {
            return redirect()->back()->with('error', 'User not found');
        }
    }

    private function setUserSession($user)
    {
        $data = [
            'id' => $user['User_id'],
            'email' => $user['Email'],
            'isLoggedIn' => true,
        ];

        session()->set($data);
    }

    public function forgotPasswordForm()
    {
        $data['title'] = 'Forgot Password';
        return view('forgot_password_form', $data);
    }

    public function sendResetPasswordEmail()
    {
        $email = $this->request->getPost('email');

        $model = new UserModel();
        $user = $model->where('Email', $email)->first();

        if ($user) {
            $resetToken = bin2hex(random_bytes(16));
            $model->update($user['User_id'], ['Reset_Token' => $resetToken]);

            if ($this->sendPasswordResetEmail($email, $resetToken)) {
                return view('reset_link_sent', ['email' => $email]);
            } else {
                return redirect()->back()->with('error', 'Failed to send password reset email. Please try again.');
            }
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }

    private function sendPasswordResetEmail($email, $token)
    {
        $emailConfig = [
            'protocol' => 'smtp',
            'SMTPHost' => 'smtp.gmail.com',
            'SMTPUser' => 'mnjeri901@gmail.com',
            'SMTPPass' => 'oieg cfjr mhcd dltc',
            'SMTPPort' => 587,
            'SMTPCrypto' => 'tls',
            'mailType' => 'html',
            'charset' => 'UTF-8',
            'newline' => "\r\n"
        ];

        $emailService = \Config\Services::email();
        $emailService->initialize($emailConfig);

        $emailService->setTo($email);
        $emailService->setSubject('Password Reset');
        $message = "<p>Please click the link below to reset your password:</p>";
        $message .= "<p><a href='".base_url('reset-password/' . $token)."'>Reset Password</a></p>";
        $emailService->setMessage($message);

        if (!$emailService->send()) {
            log_message('error', 'Email sending failed: ' . $emailService->printDebugger(['headers']));
            return false;
        }
        return true;
    }

    public function resetPasswordForm($token)
    {
        $model = new UserModel();
        $user = $model->where('Reset_Token', $token)->first();

        if (!$user) {
            return redirect()->to('/forgot-password')->with('error', 'Invalid reset token.');
        }

        $data = [
            'title' => 'Reset Password',
            'token' => $token,
            'email' => $user['Email']
        ];
        return view('reset_password_form', $data);
    }

    public function updatePassword()
    {
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
        $resetToken = $this->request->getPost('token');
        $email = $this->request->getPost('email');

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Passwords do not match.');
        }

        $model = new UserModel();
        $user = $model->where('Reset_Token', $resetToken)->first();

        if (!$user || $user['Email'] !== $email) {
            return redirect()->to('/forgot-password')->with('error', 'Invalid reset token.');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $model->update($user['User_id'], ['Password' => $hashedPassword, 'Reset_Token' => null]);

        return redirect()->to('/login')->with('success', 'Password updated successfully. You can now login.');
    }

    private function sendVerificationEmail($email, $token)
    {
        $emailConfig = [
            'protocol' => 'smtp',
            'SMTPHost' => 'smtp.gmail.com',
            'SMTPUser' => 'mnjeri901@gmail.com',
            'SMTPPass' => 'oieg cfjr mhcd dltc',
            'SMTPPort' => 587,
            'SMTPCrypto' => 'tls',
            'mailType' => 'html',
            'charset' => 'UTF-8',
            'newline' => "\r\n"
        ];

        $emailService = \Config\Services::email();
        $emailService->initialize($emailConfig);

        $activationLink = base_url("verify-email?token=" . urlencode($token));

        $message = view('verification_email', ['activationLink' => $activationLink, 'email' => $email]);

        //$message = view('verification_email', ['token' => $token, 'email' => $email]);
        
        $emailService->setTo($email);
        $emailService->setSubject('Account Verification');
        $emailService->setMessage($message);


        if (!$emailService->send()) {
            log_message('error', 'Email sending failed: ' . $emailService->printDebugger(['headers']));
            return false;
        }
        return true;
    }

    public function verifyEmail()
    {
        $token = $this->request->getGet('token');

        if (!$token) {
            // Handle case where no token is provided
            return redirect()->to('/login')->with('error', 'Verification token not found.');
        }

        $model = new UserModel();
        $user = $model->where('Verification_Token', $token)->first();

        if ($user) {
            $model->update($user['User_id'], ['Status' => 1, 'Verification_Token' => null]);
            return redirect()->to('/login')->with('success', 'Account activated successfully. You can now login.');
        } else {
            return redirect()->to('/login')->with('error', 'Invalid verification token.');
        }
    }
}
