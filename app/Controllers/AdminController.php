<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;
use App\Models\RoomModel;

class AdminController extends BaseController
{
    /* ==============================
       DASHBOARD
    ============================== */

    public function index()
    {
        $patientModel     = new PatientModel();
        $doctorModel      = new DoctorModel();
        $appointmentModel = new AppointmentModel();
        $roomModel        = new RoomModel();

        $data['stats'] = [
            'patients'           => $patientModel->countAll(),
            'doctors'            => $doctorModel->countAll(),
            'appointments_today' => $appointmentModel->countToday(),
            'rooms_available'    => $roomModel->countAvailable(),
        ];

        $data['appointments'] = $appointmentModel->getTodayAppointments();
        $data['doctors']      = $doctorModel->findAll();
        $data['rooms']        = $roomModel->findAll();

        return view('admin_view', $data);
    }

    /* ==============================
       DOCTOR CRUD
    ============================== */

    public function doctors()
    {
        $model = new DoctorModel();
        $data['doctors'] = $model->findAll();

        return view('admin/doctors/index', $data);
    }

    public function createDoctor()
    {
        return view('admin/doctors/create');
    }

    public function storeDoctor()
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

        return redirect()->to('/admin/doctors')->with('success', 'Doctor created');
    }

    public function editDoctor($id)
    {
        $model = new DoctorModel();
        $data['doctor'] = $model->find($id);

        return view('admin/doctors/edit', $data);
    }

    public function updateDoctor($id)
    {
        $model = new DoctorModel();

        $model->update($id, [
            'Doctor_name'    => $this->request->getPost('Doctor_name'),
            'Specialization' => $this->request->getPost('Specialization'),
            'Doctor_email'   => $this->request->getPost('Doctor_email'),
            'Phone'          => $this->request->getPost('Phone'),
            'Availability'   => $this->request->getPost('Availability'),
        ]);

        return redirect()->to('/admin/doctors')->with('success', 'Doctor updated');
    }

    public function deleteDoctor($id)
    {
        $model = new DoctorModel();
        $model->delete($id);

        return redirect()->to('/admin/doctors')->with('success', 'Doctor deleted');
    }
}