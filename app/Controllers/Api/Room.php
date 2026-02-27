<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Room extends ResourceController
{
    protected $modelName = 'App\Models\RoomModel';
    protected $format    = 'json';

    protected function checkLogin()
    {
        if (!session()->get('logged_in')) {
            return $this->failUnauthorized('Silakan login terlebih dahulu');
        }
    }

    public function index()
    {
        if ($res = $this->checkLogin()) return $res;

        return $this->respond(
            $this->model
                ->select('Room_Code, Room_Name, Room_Type, Status')
                ->orderBy('Room_Code', 'ASC')
                ->findAll()
        );
    }

    public function show($id = null)
    {
        if ($res = $this->checkLogin()) return $res;

        $room = $this->model
            ->select('Room_Code, Room_Name, Room_Type, Status')
            ->find($id);

        if (!$room) {
            return $this->failNotFound('Room tidak ditemukan');
        }

        return $this->respond($room);
    }

    public function create()
    {
        if ($res = $this->checkLogin()) return $res;

        if (session()->get('role') !== 'admin') {
            return $this->failForbidden('Hanya admin yang bisa menambah room');
        }

        $data = $this->request->getJSON(true);

        $this->model->insert([
            'Room_Code' => $data['Room_Code'],
            'Room_Name' => $data['Room_Name'],
            'Room_Type' => $data['Room_Type'],
            'Status'    => 'Available'
        ]);

        return $this->respondCreated([
            'message' => 'Room berhasil ditambahkan'
        ]);
    }

    public function update($id = null)
    {
        if ($res = $this->checkLogin()) return $res;

        if (session()->get('role') !== 'admin') {
            return $this->failForbidden('Hanya admin yang bisa update room');
        }

        $room = $this->model->find($id);

        if (!$room) {
            return $this->failNotFound('Room tidak ditemukan');
        }

        $this->model->update($id, $this->request->getJSON(true));

        return $this->respond([
            'message' => 'Room berhasil diupdate'
        ]);
    }

    public function delete($id = null)
    {
        if ($res = $this->checkLogin()) return $res;

        if (session()->get('role') !== 'admin') {
            return $this->failForbidden('Hanya admin yang bisa hapus room');
        }

        $room = $this->model->find($id);

        if (!$room) {
            return $this->failNotFound('Room tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Room berhasil dihapus'
        ]);
    }
}