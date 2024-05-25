<?php

namespace App\Controllers;
use App\Models\User_model;

class SignUpController extends BaseController
{
   
    //public function __construct() {
      //  parent::__construct();
        //$this->load->model('User_model'); // Load the model for interacting with the database
       // $this->load->library('email'); // Load the email library
   // }

   public function index(): string
   {
       return view('sign_up');
   }

    public function register() {
        // Generate token
        $token = bin2hex(random_bytes(16));

        // Get email from the form
        $email = $this->input->post('email');

        // Store token in the database
        $this->user_model->storeVerificationToken($email, $token);

        // Send verification email
        $this->sendVerificationEmail($email, $token);
    }

    private function sendVerificationEmail($email, $token) {
        // Configure email
        $this->email->from('mnjeri901@gmail.com', 'MediConnect');
        $this->email->to($email);
        $this->email->subject('Account Verification');
        $this->email->message('Click the following link to activate your account: ' . base_url("signup/activate?token=$token"));

        // Send email
        if (!$this->email->send()) {
            show_error($this->email->print_debugger());
        } else {
            echo "Verification email sent successfully.";
        }
    }

    public function activate() {
        $token = $this->input->get('token');
        $email = $this->user_model->getUserEmailByToken($token);

        if ($email) {
            // Update user status to activated
            $this->user_model->activateUser($email);
            echo "Account activated successfully.";
        } else {
            echo "Invalid activation link.";
        }
    }
}
