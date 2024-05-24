<?php

namespace App\Controllers;

use App\Models\DatabaseSeederModel;
use CodeIgniter\Controller;

class Seeder extends Controller
{
    public function index()
    {
        $model = new DatabaseSeederModel();
        $model->seedDatabase();

        return 'Database seeded successfully!';
    }
}
