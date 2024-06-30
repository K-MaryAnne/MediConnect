<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Role_ID' => 1, 'Role_Name' => 'Doctor', 'Description' => 'A medical doctor.'],
            ['Role_ID' => 2, 'Role_Name' => 'Nurse', 'Description' => 'A medical nurse.'],
            ['Role_ID' => 3, 'Role_Name' => 'Patient', 'Description' => 'A patient.'],
        ];

        $this->db->insert_batch('roles', $data);
    }
}
