<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class LockScreen extends Controller
{
    public function index()
    {
        if (!session()->has('logged_in')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }
        return view('lock_screen');
    }

    public function unlock()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user = $model->where('Email', $email)->first();

        if ($user && password_verify($password, $user['Password'])) {
            session()->set('logged_in', true);
            return redirect()->to('/dashboard');
        } else {
            session()->setFlashdata('error', 'Invalid credentials');
            return redirect()->to('/lock-screen');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login'); // Redirect to login after logout
    }
}
