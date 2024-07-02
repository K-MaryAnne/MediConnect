<?php

namespace App\Models;

use CodeIgniter\Model;

class RatingModel extends Model
{
    protected $table = 'ratings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'doctor_id', 'rating', 'review'];

    public function getRatingsByUserId($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }
}
