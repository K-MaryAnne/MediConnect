<?php

namespace App\Controllers;

use App\Models\User_model;
use CodeIgniter\Session\Session;

class AdminController extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new User_model();
        $this->session = session();
        // $this->session = \Config\Services::session(); // Load the session service
    }

    // Display admin profile
    public function profile()
    {
        // Fetch admin data (assuming you have a method in User_model to retrieve admin data)
        $adminId = $this->session->get('user_id');
        $admin = $this->userModel->getAdminById($adminId);

        return view('admin_profile', ['admin' => $admin]);
    }

    // Update admin profile
public function updateProfile()
{
    $request = service('request'); // Load the request service

    // Validate incoming data if necessary
    // Example: $validation = \Config\Services::validation();

    $data = [
        'First_Name' => $request->getPost('first_name'),
        'Last_Name'  => $request->getPost('last_name'),
        'Email'      => $request->getPost('email'),
        'Phone_Number' => $request->getPost('mobile_number'),
        'Address'    => $request->getPost('address'),
        'Town'       => $request->getPost('town'),
        'Date_of_Birth' => $request->getPost('date_of_birth'),
        // Add other fields as necessary
    ];

    // Remove empty values from $data array
    $data = array_filter($data, function($value) {
        return !empty($value);
    });

    // Check if there is data to update
    if (empty($data)) {
        return redirect()->back()->with('error', 'No data provided for update');
    }

    // Update admin profile in the database
    $userId = $this->session->get('user_id');
    $this->userModel->updateAdminProfile($userId, $data);

    // Optionally, redirect to a success page or reload the profile view
    return redirect()->to('admin/profile');
}
}
