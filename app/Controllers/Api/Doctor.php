<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Doctor extends ResourceController
{
    protected $modelName = 'App\Models\DoctorModel';
    protected $format    = 'json';

    protected function checkRole($allowed)
    {
        $role = $this->request->getHeaderLine('X-ROLE');
        if (!in_array($role, $allowed)) {
            return $this->failForbidden('Akses ditolak');
        }
    }

    public function index()
    {
        if ($res = $this->checkRole(['admin','doctor','patient'])) return $res;

        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        if ($res = $this->checkRole(['admin','doctor'])) return $res;

        $data = $this->model->find($id);
        if (!$data) return $this->failNotFound();

        return $this->respond($data);
    }

    public function create()
    {
        if ($res = $this->checkRole(['admin'])) return $res;

        $this->model->save($this->request->getJSON(true));

        return $this->respondCreated(['message'=>'Doctor created']);
    }

    public function update($id = null)
    {
        if ($res = $this->checkRole(['admin','doctor'])) return $res;

        $this->model->update($id, $this->request->getJSON(true));

        return $this->respond(['message'=>'Doctor updated']);
    }

    public function delete($id = null)
    {
        if ($res = $this->checkRole(['admin'])) return $res;

        $this->model->delete($id);

        return $this->respondDeleted(['message'=>'Doctor deleted']);
    }
}