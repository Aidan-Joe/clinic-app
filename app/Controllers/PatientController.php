<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\AppointmentModel;
use App\Models\MedicalRecordModel;
use App\Models\DoctorModel;

class PatientController extends BaseController
{
    public function index()
    {
        // Simple data for testing the view
        $data = [
            'authName' => 'Rina Ayu Lestari',
            'authCode' => 'PT001',
            'notifCount' => 2,
        ];
        
        return view('patient_view', $data);
        $patientCode = session()->get('Patientcode');

        $patientModel     = new PatientModel();
        $appointmentModel = new AppointmentModel();
        $recordModel      = new MedicalRecordModel();
        $doctorModel      = new DoctorModel();

        $data['patient'] = $patientModel->find($patientCode);

        $data['stats'] = [
            'upcoming' => $appointmentModel
                ->where('Patientcode', $patientCode)
                ->where('Status', 'scheduled')
                ->countAllResults(),

            'records' => $recordModel
                ->where('Patientcode', $patientCode)
                ->countAllResults(),

            'prescriptions' => $recordModel
                ->where('Patientcode', $patientCode)
                ->countAllResults(),
        ];

        $data['appointments'] = $appointmentModel
            ->where('Patientcode', $patientCode)
            ->orderBy('Appointment_date', 'DESC')
            ->findAll();

        $data['records'] = $recordModel
            ->where('Patientcode', $patientCode)
            ->orderBy('Visit_date', 'DESC')
            ->findAll();

        $data['doctors'] = $doctorModel
            ->where('Availability', 'Available')
            ->findAll();

        return view('patient/index', $data);
    }

    public function store()
    {
        $model = new AppointmentModel();

        $model->save([
            'Patientcode'      => session()->get('Patientcode'),
            'DoctorCode'       => $this->request->getPost('DoctorCode'),
            'Status'           => 'scheduled',
            'Symptoms'         => $this->request->getPost('Symptoms'),
            'Appointment_date' => $this->request->getPost('Appointment_date'),
            'Appointment_time' => $this->request->getPost('Appointment_time'),
        ]);

        return redirect()->back()->with('success', 'Appointment requested');
    }
}
