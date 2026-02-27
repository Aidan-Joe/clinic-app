<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Doctor extends ResourceController
{
    protected $modelName = 'App\Models\DoctorModel';
    protected $format = 'json';

    protected function checkLogin()
    {
        if (!session()->get('logged_in')) {
            return $this->failUnauthorized();
        }
    }

    public function index()
    {
        if ($res = $this->checkLogin()) return $res;

        return $this->respond(
            $this->model
                ->select('DoctorCode, Doctor_name, Specialization, Availability')
                ->findAll()
        );
    }

    public function show($id = null)
    {
        if ($res = $this->checkLogin()) return $res;

        return $this->respond(
            $this->model
                ->select('DoctorCode, Doctor_name, Specialization, Availability')
                ->find($id)
        );
    }

    public function create()
    {
        if ($res = $this->checkLogin()) return $res;

        if (session()->get('role') !== 'admin') {
            return $this->failForbidden('Hanya admin yang boleh menambah doctor');
        }

        $data = $this->request->getJSON(true);

        $this->model->insert([
            'DoctorCode'     => $data['DoctorCode'],
            'Doctor_name'    => $data['Doctor_name'],
            'Doctor_email'   => $data['Doctor_email'],
            'Password'       => password_hash($data['Password'], PASSWORD_DEFAULT),
            'Specialization' => $data['Specialization'],
            'Phone'          => $data['Phone'],
            'Availability'   => $data['Availability'] ?? 'Available',
        ]);

        return $this->respondCreated([
            'message' => 'Doctor berhasil ditambahkan'
        ]);
    }

    public function update($id = null)
    {
        if ($res = $this->checkLogin()) return $res;

        $role = session()->get('role');
        $code = session()->get('code');

        if ($role === 'doctor' && $id === $code) {
            $this->model->update($id, [
                'Availability' => $this->request->getVar('Availability')
            ]);

            return $this->respond([
                'message'=>'Status updated'
            ]);
        }

        if ($role === 'admin') {

            $doctor = $this->model->find($id);
            if (!$doctor) {
                return $this->failNotFound('Doctor tidak ditemukan');
            }

            $data = $this->request->getJSON(true);

            $updateData = [
                'Doctor_name'    => $data['Doctor_name'] ?? $doctor['Doctor_name'],
                'Doctor_email'   => $data['Doctor_email'] ?? $doctor['Doctor_email'],
                'Specialization' => $data['Specialization'] ?? $doctor['Specialization'],
                'Phone'          => $data['Phone'] ?? $doctor['Phone'],
                'Availability'   => $data['Availability'] ?? $doctor['Availability'],
            ];

            if (!empty($data['Password'])) {
                $updateData['Password'] = password_hash($data['Password'], PASSWORD_DEFAULT);
            }

            $this->model->update($id, $updateData);

            return $this->respond([
                'message'=>'Doctor updated'
            ]);
        }

        return $this->failForbidden();
    }

    public function delete($id = null)
    {
        if ($res = $this->checkLogin()) return $res;

        if (session()->get('role') !== 'admin') {
            return $this->failForbidden('Hanya admin yang boleh menghapus doctor');
        }

        $doctor = $this->model->find($id);

        if (!$doctor) {
            return $this->failNotFound('Doctor tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Doctor berhasil dihapus'
        ]);
    }
}