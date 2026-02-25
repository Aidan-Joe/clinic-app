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
        $patientCode = session()->get('code');

        $patientModel       = new PatientModel();
        $appointmentModel   = new AppointmentModel();
        $medicalRecordModel = new MedicalRecordModel();
        $doctorModel        = new DoctorModel();

        $patient     = $patientModel->find($patientCode);
        $records     = $medicalRecordModel->getByPatient($patientCode);
        $appointments = $appointmentModel->getAppointmentsByPatient($patientCode);

        $data['patient']      = $patient;
        $data['appointments'] = $appointments;
        $data['records']      = $records;
        $data['doctors']      = $doctorModel->findAll();
        $data['authName']     = $patient['Patient_name'] ?? session()->get('name');

        $data['stats'] = [
            'upcoming'      => $appointmentModel->countUpcomingByPatient($patientCode),
            'records'       => count($records),
            'prescriptions' => count(array_filter($records, fn($r) => !empty($r['Prescription']))),
        ];

        return view('patient_view', $data);
    }

    public function bookAppointment()
    {
        $model = new AppointmentModel();

        $model->insert([
            'Appointmentcode'  => $model->nextCode(),
            'Patientcode'      => session()->get('code'),
            'DoctorCode'       => $this->request->getPost('DoctorCode'),
            'Appointment_date' => $this->request->getPost('Appointment_date'),
            'Appointment_time' => $this->request->getPost('Appointment_time'),
            'Symptoms'         => $this->request->getPost('Symptoms'),
            'Status'           => 'scheduled',
        ]);

        return redirect()->to('/patient/dashboard')->with('success', 'Appointment booked successfully.');
    }

    public function appointments()
    {
        $patientCode = session()->get('code');
        $model       = new AppointmentModel();

        $data['appointments'] = $model->getAppointmentsByPatient($patientCode);
        $data['authName']     = session()->get('name');

        return view('patient/appointments', $data);
    }

    public function records()
    {
        $patientCode = session()->get('code');
        $model       = new MedicalRecordModel();

        $data['records']  = $model->getByPatient($patientCode);
        $data['authName'] = session()->get('name');

        return view('patient/records', $data);
    }

    public function profile()
    {
        $patientCode = session()->get('code');
        $model       = new PatientModel();
        $patient     = $model->find($patientCode);

        $data['patient']  = $patient;
        $data['authName'] = $patient['Patient_name'] ?? session()->get('name');

        return view('patient/profile', $data);
    }
}
