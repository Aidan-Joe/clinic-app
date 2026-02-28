<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\AdminModel;
use App\Models\DoctorModel;
use App\Models\PatientModel;

class Auth extends ResourceController
{
    protected $format = 'json';

    // ======================
    // POST /api/auth/login
    // ======================
    public function login()
    {
        $data = $this->request->getJSON(true);

        if (!$data || empty($data['email']) || empty($data['password'])) {
            return $this->fail('Email dan password wajib diisi');
        }

        $email    = $data['email'];
        $password = $data['password'];

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
                ]);

                return $this->respond([
                    'message' => 'Login berhasil',
                    'role'    => $role,
                    'code'    => $user[$codeField],
                    'name'    => $user[$nameField],
                ]);
            }
        }

        return $this->failUnauthorized('Email atau password salah');
    }

    // ======================
    // POST /api/auth/logout
    // ======================
    public function logout()
    {
        session()->destroy();

        return $this->respond([
            'message' => 'Logout berhasil'
        ]);
    }

    // ======================
    // GET /api/auth/me
    // ======================
    public function me()
    {
        if (!session()->get('logged_in')) {
            return $this->failUnauthorized();
        }

        return $this->respond([
            'role' => session()->get('role'),
            'code' => session()->get('code'),
            'name' => session()->get('name'),
        ]);
    }
}