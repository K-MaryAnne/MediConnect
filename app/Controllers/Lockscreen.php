<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DataException;

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
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $builder->where('Email', $username)->get()->getRow();

        if ($user && password_verify($password, $user->Password)) {
            session()->set('logged_in', true);
            return redirect()->to('/dashboard'); 
        } else {
            return redirect()->to('/lock-screen')->with('error', 'Invalid credentials');
        }
    }

    public function logout()
    {
        session()->remove('logged_in');
        return redirect()->to('/login'); // Redirect to login after logout
    }
}
