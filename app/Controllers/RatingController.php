<?php

namespace App\Controllers;

use App\Models\RatingModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class RatingController extends Controller
{
    public function rateDoctor($doctorId)
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please log in to rate a doctor.');
        }

        $ratingModel = new RatingModel();

        if ($this->request->getMethod() === 'post') {
            if ($this->validate([
                'rating' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
                'review' => 'permit_empty|max_length[255]'
            ])) {
                $data = [
                    'user_id' => $userId,
                    'doctor_id' => $doctorId,
                    'rating' => $this->request->getPost('rating'),
                    'review' => $this->request->getPost('review'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                if ($ratingModel->insert($data)) {
                    return redirect()->back()->with('success', 'Rating and review submitted successfully.');
                } else {
                    return redirect()->back()->with('error', 'Failed to submit rating and review.');
                }
            } else {
                return redirect()->back()->with('error', $this->validator->listErrors());
            }
        }

        $doctorModel = new UserModel();
        $doctor = $doctorModel->find($doctorId);
        
        return view('rate_doctor', ['doctor' => $doctor]);
    }

    public function ratePatient($patientId)
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please log in to rate a patient.');
        }

        $ratingModel = new RatingModel();

        if ($this->request->getMethod() === 'post') {
            if ($this->validate([
                'rating' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
                'review' => 'permit_empty|max_length[255]'
            ])) {
                $data = [
                    'user_id' => $userId,
                    'patient_id' => $patientId,
                    'rating' => $this->request->getPost('rating'),
                    'review' => $this->request->getPost('review'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                if ($ratingModel->insert($data)) {
                    return redirect()->back()->with('success', 'Rating and review submitted successfully.');
                } else {
                    return redirect()->back()->with('error', 'Failed to submit rating and review.');
                }
            } else {
                return redirect()->back()->with('error', $this->validator->listErrors());
            }
        }

        $patientModel = new UserModel();
        $patient = $patientModel->find($patientId);

        return view('rate_patient', ['patient' => $patient]);
    }
}
