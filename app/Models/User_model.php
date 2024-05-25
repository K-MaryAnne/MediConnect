<?php

namespace App\Models;


class User_model extends Model {

    public function storeVerificationToken($email, $token) {
        // Store token in the database
        $data = array(
            'email' => $email,
            'verification_token' => $token
        );
        $this->db->insert('users', $data);
    }

    public function getUserEmailByToken($token) {
        // Retrieve email associated with the token
        $query = $this->db->get_where('users', array('verification_token' => $token));
        $result = $query->row();
        return ($result) ? $result->email : null;
    }

    public function activateUser($email) {
        // Update user status to activated
        $this->db->where('email', $email);
        $this->db->update('users', array('status' => 1));
    }

}
