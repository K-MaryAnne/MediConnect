<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'User_id';
    protected $allowedFields = [
        'First_Name', 'Last_Name', 'Other_Names', 'Email', 'Phone_Number', 
        'Password', 'Gender', 'Age', 'Status', 'Reset_Token', 'Verification_Token'
    ];

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
        $this->where('Email', $email)->set('Status', 1)->update();
    }
}
