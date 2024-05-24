<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class ActivationController extends Controller
{
    public function activate()
    {
        $activationCode = $this->request->getGet('code'); 

        // Example logic to activate the user based on the activation code
        if ($this->validateActivationCode($activationCode)) {
            // Activate the user account
            // Update the user's status in the database, etc.
            echo 'Your account has been activated successfully!';
        } else {
            echo 'Invalid activation code';
        }
    }

    private function validateActivationCode($code)
    {
        // Example: Validate the activation code against a database record or token
        // You should implement your actual validation logic here
        return $code === 'xyz'; // Replace 'xyz' with your actual activation code or token
    }
}
