<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;
use App\Models\MedicalRecordModel;
use App\Models\RoomModel;

class DoctorController extends BaseController
{
    public function index()
    {
        $model = new DoctorModel();
        $data['doctors'] = $model->findAll();

        return view('doctor/index', $data);
    }

    public function create()
    {
        return view('doctor/create');
    }

    public function store()
    {
        $model = new DoctorModel();

        $model->insert([
            'DoctorCode'     => $this->request->getPost('DoctorCode'),
            'Doctor_name'    => $this->request->getPost('Doctor_name'),
            'Specialization' => $this->request->getPost('Specialization'),
            'Doctor_email'   => $this->request->getPost('Doctor_email'),
            'Password'       => password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT),
            'Phone'          => $this->request->getPost('Phone'),
            'Availability'   => 'Available'
        ]);

        return redirect()->to('/doctor')->with('success','Doctor created');
    }

    public function edit($id)
    {
        $model = new DoctorModel();
        $data['doctor'] = $model->find($id);

        return view('doctor/edit', $data);
    }

    public function update($id)
    {
        $model = new DoctorModel();

        $model->update($id, [
            'Doctor_name'    => $this->request->getPost('Doctor_name'),
            'Specialization' => $this->request->getPost('Specialization'),
            'Doctor_email'   => $this->request->getPost('Doctor_email'),
            'Phone'          => $this->request->getPost('Phone'),
            'Availability'   => $this->request->getPost('Availability')
        ]);

        return redirect()->to('/doctor')->with('success','Doctor updated');
    }

    public function delete($id)
    {
        $model = new DoctorModel();
        $model->delete($id);

        return redirect()->to('/doctor')->with('success','Doctor deleted');
    }
}