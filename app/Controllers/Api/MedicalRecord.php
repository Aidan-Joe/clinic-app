<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class MedicalRecord extends ResourceController
{
    protected $modelName = 'App\Models\MedicalRecordModel';
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
        if ($res = $this->checkRole(['admin','doctor','patient'])) return $res;

        $data = $this->model->find($id);
        if (!$data) return $this->failNotFound('Medical record tidak ditemukan');

        return $this->respond($data);
    }

    public function create()
    {
        if ($res = $this->checkRole(['admin','doctor'])) return $res;

        $data = $this->request->getJSON(true);

        $this->model->save($data);

        return $this->respondCreated([
            'message' => 'Medical record berhasil dibuat'
        ]);
    }

    public function update($id = null)
    {
        if ($res = $this->checkRole(['admin','doctor'])) return $res;

        if (!$this->model->find($id)) {
            return $this->failNotFound('Medical record tidak ditemukan');
        }

        $this->model->update($id, $this->request->getJSON(true));

        return $this->respond([
            'message' => 'Medical record berhasil diupdate'
        ]);
    }

    public function delete($id = null)
    {
        if ($res = $this->checkRole(['admin'])) return $res;

        if (!$this->model->find($id)) {
            return $this->failNotFound('Medical record tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Medical record berhasil dihapus'
        ]);
    }
}