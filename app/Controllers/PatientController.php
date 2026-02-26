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

        $patient  = $patientModel->find($patientCode);
        $records  = $medicalRecordModel->getByPatient($patientCode);

        $data['patient']      = $patient;
        $data['appointments'] = $appointmentModel->getAppointmentsByPatient($patientCode);
        $data['records']      = $records;
        $data['doctors']      = $doctorModel->findAll();
        $data['authName']     = $patient['Patient_name'] ?? session()->get('name');
        $data['authPhoto']    = $patient['Photo'] ?? null;

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
        $patient     = (new PatientModel())->find($patientCode);

        $data['appointments'] = (new AppointmentModel())->getAppointmentsByPatient($patientCode);
        $data['authName']     = $patient['Patient_name'] ?? session()->get('name');
        $data['authPhoto']    = $patient['Photo'] ?? null;

        return view('patient/appointments', $data);
    }

    public function records()
    {
        $patientCode = session()->get('code');
        $patient     = (new PatientModel())->find($patientCode);

        $data['records']  = (new MedicalRecordModel())->getByPatient($patientCode);
        $data['authName'] = $patient['Patient_name'] ?? session()->get('name');
        $data['authPhoto'] = $patient['Photo'] ?? null;

        return view('patient/records', $data);
    }

    public function uploadPhoto()
    {
        $patientCode = session()->get('code');
        $model       = new PatientModel();
        $patient     = $model->find($patientCode);
        $file        = $this->request->getFile('photo');
        $dir         = FCPATH . 'uploads/avatars/';

        if ($file->isValid() && !$file->hasMoved()
            && in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'], true)
            && $file->getSize() <= 2 * 1024 * 1024
        ) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $old = $patient['Photo'] ?? null;
            if ($old && file_exists($dir . $old)) {
                unlink($dir . $old);
            }

            $filename = 'patient_' . $patientCode . '_' . time() . '.' . $file->guessExtension();
            $file->move($dir, $filename);
            $model->update($patientCode, ['Photo' => $filename]);
        }

        return redirect()->to('/patient/profile')->with('success', 'Photo updated.');
    }

    public function profile()
    {
        $patientCode = session()->get('code');
        $patient     = (new PatientModel())->find($patientCode);

        $data['patient']  = $patient;
        $data['authName']  = $patient['Patient_name'] ?? session()->get('name');
        $data['authPhoto'] = $patient['Photo'] ?? null;

        return view('patient/profile', $data);
    }
}
