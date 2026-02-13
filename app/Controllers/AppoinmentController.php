<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\AppointmentModel;
use App\Models\RoomModel;

class AppointmentController extends BaseController
{
    public function index()
    {
        $model = new AppointmentModel();
        $data['appointments'] = $model->findAll();

        return view('appointment/index', $data);
    }

    public function store()
    {
        $model = new AppointmentModel();

        $model->save([
            'Appointmentcode' => $this->request->getPost('Appointmentcode'),
            'Patientcode' => $this->request->getPost('Patientcode'),
            'DoctorCode' => $this->request->getPost('DoctorCode'),
            'Status' => 'scheduled',
            'Symptoms' => $this->request->getPost('Symptoms'),
            'Appointment_date' => $this->request->getPost('Appointment_date'),
            'Appointment_time' => $this->request->getPost('Appointment_time'),
        ]);

        return redirect()->back()->with('success', 'Appointment berhasil dibuat');
    }

    public function assignRoom($id)
    {
        $appointmentModel = new AppointmentModel();
        $roomModel = new RoomModel();

        $roomCode = $this->request->getPost('Room_Code');

        $appointmentModel->update($id, [
            'Room_Code' => $roomCode,
            'Status' => 'completed'
        ]);

        $roomModel->update($roomCode, [
            'Status' => 'Occupied'
        ]);

        return redirect()->back()->with('success', 'Room berhasil diassign');
    }
}