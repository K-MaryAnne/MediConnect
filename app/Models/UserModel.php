<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'User_id';
    protected $allowedFields = [
        'First_Name', 'Last_Name', 'Other_Names', 'Email', 'Phone_Number', 
        'Password', 'Gender', 'Age', 'Status', 'Reset_Token', 'Verification_Token', 'Role_ID'
    ];

    public function register()
    {
        $data = $this->request->getPost();
        $model = new UserModel();
        $data['Password'] = password_hash($data['Password'], PASSWORD_DEFAULT);
        $data['Verification_Token'] = bin2hex(random_bytes(16));
        $data['Role_ID'] = 4; // Default Role_ID for patient

        if ($model->save($data)) {
            $this->sendVerificationEmail($data['Email'], $data['Verification_Token']);
            return redirect()->to('/login')->with('success', 'Registration successful. Please check your email to activate your account.');
        } else {
            return redirect()->back()->with('error', 'Registration failed. Please try again.');
        }
    }

    public function storeVerificationToken($email, $token)
    {
        $this->where('Email', $email)->set('Verification_Token', $token)->update();
    }

    public function getUserEmailByToken($token)
    {
        return $this->where('Verification_Token', $token)->first();
    }

    public function activateUser($email)
    {
        return $this->where('Email', $email)->set('Status', 1)->set('Verification_Token', null)->update();
    }
    
    public function storeResetToken($email, $token)
    {
        return $this->where('Email', $email)->set('Reset_Token', $token)->update();
    }

    public function getUserByResetToken($token)
    {
        return $this->where('Reset_Token', $token)->first();
    }

    public function updatePassword($email, $newPassword)
    {
        return $this->where('Email', $email)->set('Password', $newPassword)->set('Reset_Token', null)->update();
    }
}
