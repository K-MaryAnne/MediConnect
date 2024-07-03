<?php

namespace App\Models;

use CodeIgniter\Model;

class RatingModel extends Model
{
    protected $table = 'ratings';
    protected $primaryKey = 'rate_id';
    protected $allowedFields = [
        'user_id', 'doctor_id', 'patient_id', 'rating', 'review', 'created_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}
