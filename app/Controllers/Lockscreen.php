<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class LockScreen extends Controller
{
    public function index()
    {
    
        if (session()->has('logged_in')) {
            return redirect()->to('/lock-screen/unlock'); 
        }

        
        return view('lock_screen');
    }

    public function unlock()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if ($username === 'admin' && $password === 'password') {
            session()->set('logged_in', true);
            return redirect()->to('/lock-screen/unlock'); 
        } else {
            return redirect()->to('/lock-screen')->with('error', 'Invalid credentials');
        }
    }

    public function logout()
    {
        session()->remove('logged_in');
        return redirect()->to('/lock-screen');
    }
}
