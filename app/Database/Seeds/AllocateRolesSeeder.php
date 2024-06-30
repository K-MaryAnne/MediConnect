<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\User_model;

class AllocateRolesSeeder extends Seeder {
    public function run() {
        $userModel = new User_model();
        $applications = $userModel->get_all_applications();

        foreach ($applications as $application) {
            $data = [
                'User_ID' => $application->User_ID,
                'First_Name' => $application->first_name,
                'Last_Name' => $application->last_name,
                'Specialisation' => $application->Specialisation,
                'Years_of_Experience' => $application->Years_of_Experience,
                'Rating' => 0,
                'status' => 'active'
            ];
            if ($application->role_applied_for == 'doctor') {
                $data['Role_ID'] = 2; // Assuming 2 is the Role_ID for doctors
                $userModel->insert_doctor($data);
            } elseif ($application->role_applied_for == 'nurse') {
                $data['Role_ID'] = 3; // Assuming 3 is the Role_ID for nurses
                $userModel->insert_nurse($data);
            }
        }
    }
}

