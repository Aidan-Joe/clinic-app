<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RoomModel;

class RoomController extends BaseController
{
    public function index()
    {
        $model = new RoomModel();
        $data['rooms'] = $model->findAll();

        return view('room/index', $data);
    }

    public function create()
    {
        return view('room/create');
    }

    public function store()
    {
        $model = new RoomModel();

        $model->insert([
            'Room_Code' => $this->request->getPost('Room_Code'),
            'Room_Name' => $this->request->getPost('Room_Name'),
            'Room_Type' => $this->request->getPost('Room_Type'),
            'Status'    => 'Available'
        ]);

        return redirect()->to('/room')->with('success','Room created');
    }

    public function edit($id)
    {
        $model = new RoomModel();
        $data['room'] = $model->find($id);

        return view('room/edit', $data);
    }

    public function update($id)
    {
        $model = new RoomModel();

        $model->update($id, [
            'Room_Name' => $this->request->getPost('Room_Name'),
            'Room_Type' => $this->request->getPost('Room_Type'),
            'Status'    => $this->request->getPost('Status')
        ]);

        return redirect()->to('/room')->with('success','Room updated');
    }

    public function delete($id)
    {
        $model = new RoomModel();
        $model->delete($id);

        return redirect()->to('/room')->with('success','Room deleted');
    }
}