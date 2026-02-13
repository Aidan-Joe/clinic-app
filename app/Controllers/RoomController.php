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

    public function updateStatus($id)
    {
        $model = new RoomModel();

        $model->update($id, [
            'Status' => $this->request->getPost('Status')
        ]);

        return redirect()->back()->with('success', 'Room status updated');
    }
}