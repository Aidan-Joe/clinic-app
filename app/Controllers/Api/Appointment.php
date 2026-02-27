<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Appointment extends ResourceController
{
    protected $modelName = 'App\Models\AppointmentModel';
    protected $format    = 'json';

    protected function checkLogin()
    {
        if (!session()->get('logged_in')) {
            return $this->failUnauthorized();
        }
    }
    public function show($id = null)
    {
        if ($res = $this->checkLogin()) return $res;

        $appointment = $this->model->find($id);

        if (!$appointment) {
            return $this->failNotFound('Appointment tidak ditemukan');
        }

        $role = session()->get('role');
        $code = session()->get('code');

        if ($role === 'admin') {
            return $this->respond($appointment);
        }

        if ($role === 'doctor' && $appointment['DoctorCode'] === $code) {
            return $this->respond($appointment);
        }

        if ($role === 'patient' && $appointment['Patientcode'] === $code) {
            return $this->respond($appointment);
        }

        return $this->failForbidden();
    }
    public function index()
    {
        if ($res = $this->checkLogin()) return $res;

        $role = session()->get('role');
        $code = session()->get('code');

        if ($role === 'admin') {
            return $this->respond($this->model->findAll());
        }

        if ($role === 'doctor') {
            return $this->respond(
                $this->model->where('DoctorCode', $code)->findAll()
            );
        }

        if ($role === 'patient') {
            return $this->respond(
                $this->model->where('Patientcode', $code)->findAll()
            );
        }

        return $this->failForbidden();
    }

    public function create()
    {
        if ($res = $this->checkLogin()) return $res;

        $role = session()->get('role');
        $code = session()->get('code');

        if (!in_array($role, ['admin', 'patient'])) {
            return $this->failForbidden();
        }

        $data = $this->request->getJSON(true);

        if ($role === 'patient') {
            $data['Patientcode'] = $code;
        }

        $data['Appointmentcode'] = $this->model->nextCode();
        $data['Status'] = 'scheduled';

        $this->model->insert($data);

        return $this->respondCreated(['message' => 'Appointment created']);
    }

    public function update($id = null)
    {
        if ($res = $this->checkLogin()) return $res;

        if (session()->get('role') !== 'admin') {
            return $this->failForbidden();
        }

        $this->model->update($id, $this->request->getJSON(true));

        return $this->respond(['message' => 'Appointment updated']);
    }

    public function delete($id = null)
    {
        if ($res = $this->checkLogin()) return $res;

        if (session()->get('role') !== 'admin') {
            return $this->failForbidden();
        }

        $this->model->delete($id);

        return $this->respondDeleted(['message' => 'Appointment deleted']);
    }
}
