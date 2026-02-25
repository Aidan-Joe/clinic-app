<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\DoctorModel;
use App\Models\PatientModel;

class AuthController extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(session()->get('role') . '/dashboard');
        }

        return view('auth/login');
    }

    public function login()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $candidates = [
            'admin'   => [new AdminModel(),   'Admin_email',   'AdminCode',   'Admin_name'],
            'doctor'  => [new DoctorModel(),  'Doctor_email',  'DoctorCode',  'Doctor_name'],
            'patient' => [new PatientModel(), 'Patient_email', 'Patientcode', 'Patient_name'],
        ];

        foreach ($candidates as $role => [$model, $emailField, $codeField, $nameField]) {
            $user = $model->where($emailField, $email)->first();

            if ($user && password_verify($password, $user['Password'])) {
                session()->set([
                    'logged_in' => true,
                    'role'      => $role,
                    'code'      => $user[$codeField],
                    'name'      => $user[$nameField],
                    'email'     => $email,
                ]);

                return redirect()->to($role . '/dashboard');
            }
        }

        return redirect()->back()->with('error', 'Invalid email or password.')->withInput();
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
