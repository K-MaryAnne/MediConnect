<?php

namespace App\Controllers;

use App\Models\Stats_model;

class Stats extends BaseController
{

    protected $statsModel;

    public function __construct()
    {
        // Load the model through dependency injection
        $this->statsModel = new Stats_model();
    }


    public function index() {
       
        
        // Get data from the model
        $data['doctor_count'] = $this->statsModel->get_count('doctors');
        $data['nurse_count'] = $this->statsModel->get_count('nurses');
        $data['patient_count'] = $this->statsModel->get_count('patients');
        
         // Load view with data using view() helper function
         return view('stats_view', $data);
    }
}
