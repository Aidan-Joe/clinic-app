<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Patient extends ResourceController
{
    protected $modelName = 'App\Models\PatientModel';
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
        if (!$data) return $this->failNotFound();

        return $this->respond($data);
    }

    public function create() { return $this->failForbidden(); }
    public function update($id = null) { return $this->failForbidden(); }
    public function delete($id = null) { return $this->failForbidden(); }
}