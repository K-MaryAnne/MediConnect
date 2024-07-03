<?php
namespace App\Controllers;

use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        $userId = $session->get('user_id');

        if ($userId) {
            $userModel = new UserModel();
            $user = $userModel->find($userId);
            
            if ($user) {
                return view('dashboard', ['user' => $user]);
            } else {
                return redirect()->to('/login')->with('error', 'User not found.');
            }
        } else {
            return redirect()->to('/login')->with('error', 'Please log in.');
        }
    }
}
