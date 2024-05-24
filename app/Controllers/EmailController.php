<?php 

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel; 
class EmailController extends Controller
{
    public function sendActivationEmail($userId)
    {
        $userModel = new UserModel();
        $user = $userModel->find($userId); 

        if ($user) {
            $email = \Config\Services::email();

            $email->setFrom('MediConnect@gmail.com', 'MediConnect');  
            $email->setTo($user['email']); 
            $email->setSubject('Account Activation');
            $email->setMessage('<p>Click <a href="https://yourdomain.com/activate?code=xyz">here</a> to activate your account.</p>');

            if ($email->send()) {
                echo 'Email successfully sent';
            } else {
                // Print debugging information in case of failure
                $data = $email->printDebugger(['headers']);
                print_r($data);
            }
        } else {
            echo 'User not found'; 
        }
    }
}
