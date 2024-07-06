<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\UserModel;

class AppointmentController extends BaseController
{
    public function index()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please log in to view appointments.');
        }

        $appointmentModel = new AppointmentModel();
        $appointments = $appointmentModel->where('user_id', $userId)->findAll();

        return view('appointments/index', ['appointments' => $appointments]);
    }

    public function book()
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please log in to book an appointment.');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'provider_id' => 'required|integer',
                'appointment_date' => 'required|valid_date[Y-m-d H:i:s]',
            ];

            if ($this->validate($rules)) {
                $appointmentModel = new AppointmentModel();
                $data = [
                    'user_id' => $userId,
                    'provider_id' => $this->request->getPost('provider_id'),
                    'appointment_date' => $this->request->getPost('appointment_date'),
                ];

                if ($appointmentModel->save($data)) {
                    return redirect()->to('/appointments')->with('success', 'Appointment booked successfully.');
                } else {
                    return redirect()->to('/appointments')->with('error', 'Failed to book appointment.');
                }
            } else {
                return redirect()->back()->withInput()->with('validation', $this->validator);
            }
        }

        $providerModel = new UserModel();
        $providers = $providerModel->where('role', 'provider')->findAll();

        return view('appointments/book', ['providers' => $providers]);
    }

    // Additional methods like cancel, reschedule, etc. can be added here
}
