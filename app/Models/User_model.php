<?php

namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model
{
    protected $table = 'doctors';
    protected $primaryKey = 'User_ID';

    protected $allowedFields = [
        'User_ID',
        'Role_ID',
        'First_Name',
        'Last_Name',
        'Specialisation',
        'Years_of_Experience',
        'Rating',
        'status',
        'Email'
    ];

    // Insert doctor
    public function insert_doctor($data) {
        return $this->db->table('doctors')->insert($data);
    }
    
    // Insert nurse
    public function insert_nurse($data) {
        return $this->db->table('nurses')->insert($data);
    }

    // Get all doctors
    public function get_all_doctors() {
        return $this->db->table('doctors')->get()->getResult();
    }
    
    // Get doctor by ID
    public function get_doctor_by_id($id) {
        return $this->db->table('doctors')->getWhere(['User_ID' => $id])->getRow();
    }

    // Get all nurses
    public function get_all_nurses() {
        return $this->db->table('nurses')->get()->getResult();
    }

    // Get nurse by ID
    public function get_nurse_by_id($id) {
        return $this->db->table('nurses')->getWhere(['User_ID' => $id])->getRow();
    }

    // Get all patients
    public function get_all_patients() {
        return $this->db->table('patients')->get()->getResult();
    }
    
    // Update doctor
    public function update_doctor($id, $data) {
        return $this->db->table('doctors')->update($data, ['User_ID' => $id]);
    }

    // Update nurse
    public function update_nurse($id, $data) {
        return $this->db->table('nurses')->update($data, ['User_ID' => $id]);
    }
    
    // Delete doctor
    public function delete_doctor($id) {
        return $this->db->table('doctors')->delete(['User_ID' => $id]);
    }

    // Delete nurse
    public function delete_nurse($id) {
        return $this->db->table('nurses')->delete(['User_ID' => $id]);
    }

    // Get all applications
    public function get_all_applications() {
        return $this->db->table('user_applications')->get()->getResult();
    }

    // Get application by ID
    public function get_application_by_id($id) {
        return $this->db->table('user_applications')->where('id', $id)->get()->getRow();
    }

    // Accept application
    public function accept_application($application_id, $user_data) {
        // Update user role in users table
        $this->db->where('User_ID', $user_data['User_ID']);
        $this->db->update('users', ['Role_ID' => $user_data['Role_ID']]);
        
        // Insert into doctors or nurses table
        if ($user_data['Role_ID'] == 2) {
            // Doctor
            return $this->db->insert('doctors', $user_data);
        } elseif ($user_data['Role_ID'] == 3) {
            // Nurse
            return $this->db->insert('nurses', $user_data);
        }
        
        return false;
    }

    // Deny application
    public function deny_application($application_id) {
        return $this->db->delete('user_applications', ['id' => $application_id]);
    }

    // Update application status
    public function update_application_status($id, $status) {
        return $this->db->table('user_applications')->where('id', $id)->update(['status' => $status]);
    }

    
}
