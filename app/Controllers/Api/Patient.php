<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Patient extends ResourceController
{
    protected $modelName = 'App\Models\PatientModel';
    protected $format = 'json';

    protected function checkLogin()
    {
        if (!session()->get('logged_in')) {
            return $this->failUnauthorized();
        }
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return $this->failUnauthorized();
        }

        $role = session()->get('role');
        $code = session()->get('code');

        if ($role === 'admin') {
            return $this->respond(
                $this->model
                    ->select('Patientcode, Patient_name, Patient_email, Phone, Birthdate, Gender, Address, Photo')
                    ->findAll()
            );
        }

        if ($role === 'doctor') {
            return $this->respond(
                $this->model
                    ->select('Patientcode, Patient_name, Phone, Gender')
                    ->findAll()
            );
        }

        if ($role === 'patient') {
            return $this->respond(
                $this->model
                    ->select('Patientcode, Patient_name, Patient_email, Phone, Birthdate, Gender, Address, Photo')
                    ->where('Patientcode', $code)
                    ->findAll()
            );
        }

        return $this->failForbidden();
    }
    public function show($id = null)
    {
        if ($res = $this->checkLogin()) return $res;

        $role = session()->get('role');
        $code = session()->get('code');

        if ($role === 'admin') {
            return $this->respond($this->model->find($id));
        }

        if ($role === 'patient' && $id === $code) {
            return $this->respond($this->model->find($id));
        }

        if ($role === 'doctor') {
            return $this->respond($this->model->find($id));
        }

        return $this->failForbidden();
    }
    public function create()
    {
        if (!session()->get('logged_in')) {
            return $this->failUnauthorized();
        }

        if (session()->get('role') !== 'admin') {
            return $this->failForbidden('Hanya admin yang boleh menambah patient');
        }

        $data = $this->request->getJSON(true);

        $this->model->insert([
            'Patientcode'   => $data['Patientcode'],
            'Patient_name'  => $data['Patient_name'],
            'Patient_email' => $data['Patient_email'],
            'Password'      => password_hash($data['Password'], PASSWORD_DEFAULT),
            'Phone'         => $data['Phone'],
            'Birthdate'     => $data['Birthdate'],
            'Gender'        => $data['Gender'],
            'Address'       => $data['Address'],
        ]);

        return $this->respondCreated([
            'message' => 'Patient berhasil ditambahkan'
        ]);
    }
    public function update($id = null)
    {
        if (!session()->get('logged_in')) {
            return $this->failUnauthorized();
        }

        if (session()->get('role') !== 'admin') {
            return $this->failForbidden('Hanya admin yang boleh mengupdate patient');
        }

        $patient = $this->model->find($id);

        if (!$patient) {
            return $this->failNotFound('Patient tidak ditemukan');
        }

        $data = $this->request->getJSON(true);

        $updateData = [
            'Patient_name'  => $data['Patient_name'] ?? $patient['Patient_name'],
            'Patient_email' => $data['Patient_email'] ?? $patient['Patient_email'],
            'Phone'         => $data['Phone'] ?? $patient['Phone'],
            'Birthdate'     => $data['Birthdate'] ?? $patient['Birthdate'],
            'Gender'        => $data['Gender'] ?? $patient['Gender'],
            'Address'       => $data['Address'] ?? $patient['Address'],
        ];

        if (!empty($data['Password'])) {
            $updateData['Password'] = password_hash($data['Password'], PASSWORD_DEFAULT);
        }

        $this->model->update($id, $updateData);

        return $this->respond([
            'message' => 'Patient berhasil diupdate'
        ]);
    }

    public function delete($id = null)
    {
        if (!session()->get('logged_in')) {
            return $this->failUnauthorized();
        }

        if (session()->get('role') !== 'admin') {
            return $this->failForbidden('Hanya admin yang boleh menghapus patient');
        }

        $patient = $this->model->find($id);

        if (!$patient) {
            return $this->failNotFound('Patient tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Patient berhasil dihapus'
        ]);
    }
}
