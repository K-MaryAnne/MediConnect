<?php

namespace App\Controllers;

use App\Models\User_model;

class AdminController extends BaseController
{
    protected $userModel;

    public function __construct() {
        $this->userModel = new User_model();
    }

    // Display admin profile
    public function profile() {
        // You can fetch admin data if needed
        // $data['admin'] = $this->userModel->get_admin_data();

        return view('admin_profile');
    }
}
