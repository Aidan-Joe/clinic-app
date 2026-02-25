<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AppointmentModel;
use App\Models\RoomModel;
use App\Models\PatientModel;
use App\Models\DoctorModel;

class AppointmentController extends BaseController
{
    public function index()
    {
        $model = new AppointmentModel();
        $data['appointments'] = $model->findAll();

        return view('appointment/index', $data);
    }

    public function create()
    {
        $patientModel = new PatientModel();
        $doctorModel  = new DoctorModel();

        $data['patients'] = $patientModel->findAll();
        $data['doctors']  = $doctorModel->findAll();

        return view('appointment/create', $data);
    }

    public function store()
    {
        $model = new AppointmentModel();

        $model->insert([
            'Appointmentcode' => 'APT' . rand(1000, 9999),
            'Patientcode'     => $this->request->getPost('Patientcode'),
            'DoctorCode'      => $this->request->getPost('DoctorCode'),
            'Symptoms'        => $this->request->getPost('Symptoms'),
            'Appointment_date' => $this->request->getPost('Appointment_date'),
            'Appointment_time' => $this->request->getPost('Appointment_time'),
            'Status'          => 'scheduled'
        ]);

        return redirect()->to('/appointment')->with('success', 'Appointment created');
    }

    public function edit($id)
    {
        $model = new AppointmentModel();
        $data['appointment'] = $model->find($id);

        return view('appointment/edit', $data);
    }

    public function update($id)
    {
        $model = new AppointmentModel();

        $model->update($id, [
            'DoctorCode'       => $this->request->getPost('DoctorCode'),
            'Appointment_date' => $this->request->getPost('Appointment_date'),
            'Appointment_time' => $this->request->getPost('Appointment_time'),
            'Symptoms'         => $this->request->getPost('Symptoms'),
            'Status'           => $this->request->getPost('Status'),
        ]);

        return redirect()->to('/appointment')->with('success', 'Appointment updated');
    }

    public function delete($id)
    {
        $appointmentModel = new AppointmentModel();
        $roomModel        = new RoomModel();

        $appointment = $appointmentModel->find($id);

        if ($appointment && $appointment['Room_Code']) {
            $roomModel->update($appointment['Room_Code'], [
                'Status' => 'Available'
            ]);
        }

        $appointmentModel->delete($id);

        return redirect()->to('/appointment')->with('success', 'Appointment deleted');
    }
}
