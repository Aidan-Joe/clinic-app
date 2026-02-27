<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class MedicalRecord extends ResourceController
{
    protected $modelName = 'App\Models\MedicalRecordModel';
    protected $format = 'json';

    protected function checkLogin()
    {
        if (!session()->get('logged_in')) {
            return $this->failUnauthorized('Silakan login terlebih dahulu');
        }
    }

    protected function role()
    {
        return session()->get('role');
    }

    protected function code()
    {
        return session()->get('code');
    }

    public function index()
    {
        if ($res = $this->checkLogin()) return $res;

        $role = $this->role();
        $code = $this->code();

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

    public function show($id = null)
    {
        if ($res = $this->checkLogin()) return $res;

        $record = $this->model->find($id);

        if (!$record) {
            return $this->failNotFound('Record tidak ditemukan');
        }

        $role = $this->role();
        $code = $this->code();

        if ($role === 'admin') {
            return $this->respond($record);
        }

        if ($role === 'doctor' && $record['DoctorCode'] === $code) {
            return $this->respond($record);
        }

        if ($role === 'patient' && $record['Patientcode'] === $code) {
            return $this->respond($record);
        }

        return $this->failForbidden();
    }

    public function create()
    {
        if ($res = $this->checkLogin()) return $res;

        if (!in_array($this->role(), ['admin','doctor'])) {
            return $this->failForbidden();
        }

        $data = $this->request->getJSON(true);

        $data['RecordCode'] = $this->model->nextCode();

        if ($this->role() === 'doctor') {
            $data['DoctorCode'] = $this->code();
        }

        $this->model->insert($data);

        return $this->respondCreated([
            'message' => 'Medical record berhasil dibuat'
        ]);
    }

    public function update($id = null)
    {
        if ($res = $this->checkLogin()) return $res;

        $record = $this->model->find($id);

        if (!$record) {
            return $this->failNotFound('Record tidak ditemukan');
        }

        $role = $this->role();
        $code = $this->code();

        if ($role === 'admin') {
            $this->model->update($id, $this->request->getJSON(true));
            return $this->respond(['message'=>'Record updated']);
        }

        if ($role === 'doctor' && $record['DoctorCode'] === $code) {
            $this->model->update($id, $this->request->getJSON(true));
            return $this->respond(['message'=>'Record updated']);
        }

        return $this->failForbidden();
    }

    public function delete($id = null)
    {
        if ($res = $this->checkLogin()) return $res;

        if ($this->role() !== 'admin') {
            return $this->failForbidden('Hanya admin yang boleh menghapus record');
        }

        $record = $this->model->find($id);

        if (!$record) {
            return $this->failNotFound('Record tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'message'=>'Record deleted'
        ]);
    }
}