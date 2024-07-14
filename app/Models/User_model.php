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

    // Insert patient
    public function insert_patient($data) {
        return $this->db->table('patients')->insert($data);
    }

    // Insert denied application
    public function insert_denied_application($data) {
        return $this->db->table('denied_applications')->insert($data);
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

    // Get patient by ID
    public function get_patient_by_id($id) {
        return $this->db->table('patients')->getWhere(['User_ID' => $id])->getRow();
    }
    
    // Update doctor
    public function update_doctor($id, $data) {
        return $this->db->table('doctors')->update($data, ['User_ID' => $id]);
    }

    // Update nurse
    public function update_nurse($id, $data) {
        return $this->db->table('nurses')->update($data, ['User_ID' => $id]);
    }

    // Update patient
    public function update_patient($id, $data) {
        return $this->db->table('patients')->update($data, ['User_ID' => $id]);
    }
    
    // Delete doctor
    public function delete_doctor($id) {
        return $this->db->table('doctors')->delete(['User_ID' => $id]);
    }

    // Delete nurse
    public function delete_nurse($id) {
        return $this->db->table('nurses')->delete(['User_ID' => $id]);
    }

    // Delete patient
    public function delete_patient($id) {
        return $this->db->table('patients')->delete(['User_ID' => $id]);
    }

     // Method to get all pending applications
     public function get_pending_applications() {
        return $this->where('status', 'pending')->findAll();
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
        
        // Insert into doctors, nurses or patients table if not exists
        if ($user_data['Role_ID'] == 2) {
            // Doctor
            if (!$this->db->table('doctors')->where(['User_ID' => $user_data['User_ID']])->get()->getRow()) {
                return $this->db->table('doctors')->insert($user_data);
            }
        } elseif ($user_data['Role_ID'] == 3) {
            // Nurse
            if (!$this->db->table('nurses')->where(['User_ID' => $user_data['User_ID']])->get()->getRow()) {
                return $this->db->table('nurses')->insert($user_data);
            }
        } elseif ($user_data['Role_ID'] == 4) {
            // Patient
            if (!$this->db->table('patients')->where(['User_ID' => $user_data['User_ID']])->get()->getRow()) {
                return $this->db->table('patients')->insert($user_data);
            }
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

    public function delete_application($application_id) {
        return $this->db->table('user_applications')->where('id', $application_id)->delete();
    }
    
    // Update user role in users table
    public function update_user_role($user_id, $role_id) {
        return $this->db->table('users')->where('User_ID', $user_id)->update(['Role_ID' => $role_id]);
    }

    public function suspend_doctor($id) {
        // Fetch the doctor's details
        $doctor = $this->db->table('doctors')->where('User_ID', $id)->get()->getRowArray();
        
        if ($doctor) {
            // Insert doctor details into suspended_healthcare_providers table
            $this->db->table('suspended_healthcare_providers')->insert($doctor);
    
            // Update the role of the doctor in the users table
            $this->db->table('users')->where('User_id', $id)->update(['Role_ID' => 5]);
    
            // Remove the doctor from the doctors table
            return $this->db->table('doctors')->where('User_ID', $id)->delete();
        }
        return false;
    }

     // Fetch suspended doctors from suspended_healthcare_providers table
     public function getSuspendedDoctors() {
        return $this->db->table('suspended_healthcare_providers')
                        ->where('Role_ID', 2)
                        ->get()
                        ->getResult();
    }

    // Restore a suspended doctor
    public function restoreDoctor($id) {
        // Fetch suspended doctor details
        $suspendedDoctor = $this->db->table('suspended_healthcare_providers')
                                    ->where('User_ID', $id)
                                    ->where('Role_ID', 2)
                                    ->get()
                                    ->getRow();
        
        if ($suspendedDoctor) {
            // Move the doctor back to the doctors table
            $doctorData = [
                'User_ID' => $suspendedDoctor->User_ID,
                'Role_ID' => 2,
                'First_Name' => $suspendedDoctor->First_Name,
                'Last_Name' => $suspendedDoctor->Last_Name,
                'Email' => $suspendedDoctor->Email,
                'Specialisation' => $suspendedDoctor->Specialisation,
                'Years_of_Experience' => $suspendedDoctor->Years_of_Experience,
                'Rating' => $suspendedDoctor->Rating,
                'status' => 'active'
            ];
            $this->db->table('doctors')->insert($doctorData);
            
            // Update Role_ID in users table
            $this->db->table('users')
                     ->where('User_id', $id)
                     ->update(['Role_ID' => 2, 'is_suspended' => 0]);

            // Remove from suspended_healthcare_providers table
            return $this->db->table('suspended_healthcare_providers')
                            ->where('User_ID', $id)
                            ->where('Role_ID', 2)
                            ->delete();
        }
        
        return false;
    }



    public function searchDoctor($query)
    {
        return $this->like('Email', $query)
                    ->orLike('First_Name', $query)
                    ->orLike('Last_Name', $query)
                    ->orLike('Specialisation', $query)
                    ->findAll();
    }


    public function suspend_nurse($id) {
        // Fetch the nurse's details
        $nurse = $this->db->table('nurses')->where('User_ID', $id)->get()->getRowArray();
        
        if ($nurse) {
            // Insert nurse details into suspended_healthcare_providers table
            $this->db->table('suspended_healthcare_providers')->insert($nurse);
    
            // Update the role of the nurse in the users table
            $this->db->table('users')->where('User_id', $id)->update(['Role_ID' => 5]);
    
            // Remove the nurse from the nurses table
            return $this->db->table('nurses')->where('User_ID', $id)->delete();
        }
        return false;
    }

     // Fetch suspended nurses from suspended_healthcare_providers table
     public function getSuspendedNurses() {
        return $this->db->table('suspended_healthcare_providers')
                        ->where('Role_ID', 3)
                        ->get()
                        ->getResult();
    }

    // Restore a suspended nurse
    public function restoreNurse($id) {
        // Fetch suspended nurse details
        $suspendedNurse = $this->db->table('suspended_healthcare_providers')
                                    ->where('User_ID', $id)
                                    ->where('Role_ID', 3)
                                    ->get()
                                    ->getRow();
        
        if ($suspendedNurse) {
            // Move the nurse back to the nurses table
            $nurseData = [
                'User_ID' => $suspendedNurse->User_ID,
                'Role_ID' => 3,
                'First_Name' => $suspendedNurse->First_Name,
                'Last_Name' => $suspendedNurse->Last_Name,
                'Email' => $suspendedNurse->Email,
                'Specialisation' => $suspendedNurse->Specialisation,
                'Years_of_Experience' => $suspendedNurse->Years_of_Experience,
                'Rating' => $suspendedNurse->Rating,
                'status' => 'active'
            ];
            $this->db->table('nurses')->insert($nurseData);
            
            // Update Role_ID in users table
            $this->db->table('users')
                     ->where('User_id', $id)
                     ->update(['Role_ID' => 3, 'is_suspended' => 0]);

            // Remove from suspended_healthcare_providers table
            return $this->db->table('suspended_healthcare_providers')
                            ->where('User_ID', $id)
                            ->where('Role_ID', 3)
                            ->delete();
        }
        
        return false;
    }



    public function searchNurse($query)
    {
        return $this->like('Email', $query)
                    ->orLike('First_Name', $query)
                    ->orLike('Last_Name', $query)
                    ->orLike('Specialisation', $query)
                    ->findAll();
    }

    public function searchPatient($query)
    {
        return $this->like('Email', $query)
                    ->orLike('First_Name', $query)
                    ->orLike('Last_Name', $query)
                    ->findAll();
    }
    

  // Fetch admin data by ID
  public function getAdminById($adminId)
  {
      return $this->find($adminId);
  }

  // Update admin profile
public function updateAdminProfile($adminId, $data)
{
    // Ensure the update operation is targeted to a specific admin using User_ID
    return $this->where('User_ID', $adminId)->update($data);
}


  public function upload_admin_profile_image($admin_id, $image_path)
  {
      return $this->db->table('admins')->where('User_ID', $admin_id)->update(['profile_image' => $image_path]);
  }
}
