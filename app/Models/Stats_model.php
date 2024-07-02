<?php

namespace App\Models;

use CodeIgniter\Model;

class Stats_model extends Model
{
    protected $table;

    public function __construct()
    {
        parent::__construct();
        // Default table can be 'doctors', adjust as necessary
        $this->table = 'doctors';
    }

    public function get_count($table)
    {
        $this->table = $table; // Set the table dynamically
        return $this->db->table($this->table)->countAllResults();
    }
    
}
