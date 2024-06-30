<?php

namespace App\Controllers;

use App\Models\User_model;

class NurseCrudController extends BaseController
{
    protected $userModel;

    public function __construct() {
        $this->userModel = new User_model();
    }
    
    
    // View Nurses
    public function view_nurses() {
        $data['nurses'] = $this->userModel->get_all_nurses();
        echo view('nurses_view', $data);
    }
    // Add new nurses
    public function add() {
        // Handle form submission to insert admin
    }
    
    // Edit nurse
    public function edit($id) {
        // Handle form submission to update admin
    }
    
    // Delete nurse
    public function delete($id) {
        // Handle deletion of admin
    }

       
    
}
