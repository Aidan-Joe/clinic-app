<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;
use App\Models\MedicalRecordModel;
use App\Models\PatientModel;
use App\Models\RoomModel;

class DoctorController extends BaseController
{
    public function index()
    {
        $doctorCode = session()->get('code');

        $doctorModel        = new DoctorModel();
        $appointmentModel   = new AppointmentModel();
        $medicalRecordModel = new MedicalRecordModel();
        $roomModel          = new RoomModel();

        $doctor = $doctorModel->find($doctorCode);
        $queue  = $appointmentModel->getTodayQueueByDoctor($doctorCode);
        $first  = !empty($queue) ? $queue[0] : null;

        $data['stats'] = [
            'appointments_today' => $appointmentModel->countTodayByDoctor($doctorCode),
            'completed'          => $appointmentModel->countCompletedByDoctor($doctorCode),
            'total_patients'     => $appointmentModel->countTotalPatientsByDoctor($doctorCode),
            'records_pending'    => $medicalRecordModel->countPendingByDoctor($doctorCode),
        ];

        $data['queue']         = $queue;
        $data['nextPatient']   = $first;
        $data['recentRecords'] = $medicalRecordModel->getRecentByDoctor($doctorCode);
        $data['myRoom']        = ($first && !empty($first['Room_Code'])) ? $roomModel->find($first['Room_Code']) : null;

        $data['authName']      = $doctor['Doctor_name'] ?? session()->get('name');
        $data['authCode']      = $doctorCode;
        $data['authSpec']      = $doctor['Specialization'] ?? '';
        $data['authAvailable'] = $doctor['Availability'] === 'Available';
        $data['authPhoto']     = $doctor['Photo'] ?? null;
        $data['activeNav']     = 'dashboard';
        $data['sidebarRole']   = 'doctor';

        return view('doctor_view', $data);
    }

    public function updateAvailability()
    {
        $doctorCode = session()->get('code');
        $model      = new DoctorModel();
        $doctor     = $model->find($doctorCode);

        $model->update($doctorCode, [
            'Availability' => $doctor['Availability'] === 'Available' ? 'Not Available' : 'Available',
        ]);

        return redirect()->back();
    }

    public function appointments()
    {
        $doctorCode = session()->get('code');
        $doctor     = (new DoctorModel())->find($doctorCode);
        $model      = new AppointmentModel();

        $data['appointments'] = $model->select('
                appointment.Appointmentcode,
                appointment.Patientcode,
                appointment.Appointment_date,
                appointment.Appointment_time,
                appointment.Symptoms,
                appointment.Status,
                patient.Patient_name
            ')
            ->join('patient', 'patient.Patientcode = appointment.Patientcode', 'left')
            ->where('appointment.DoctorCode', $doctorCode)
            ->orderBy('Appointment_date', 'DESC')
            ->findAll();

        $data['authName']      = $doctor['Doctor_name'] ?? session()->get('name');
        $data['authCode']      = $doctorCode;
        $data['authSpec']      = $doctor['Specialization'] ?? '';
        $data['authAvailable'] = $doctor['Availability'] === 'Available';
        $data['authPhoto']     = $doctor['Photo'] ?? null;
        $data['activeNav']     = 'appointments';
        $data['sidebarRole']   = 'doctor';

        return view('doctor/appointments', $data);
    }

    public function updateAppointmentStatus($id)
    {
        $model = new AppointmentModel();
        $model->update($id, ['Status' => $this->request->getPost('Status')]);

        return redirect()->to('/doctor/appointments')->with('success', 'Status updated.');
    }

    public function records()
    {
        $doctorCode = session()->get('code');
        $doctor     = (new DoctorModel())->find($doctorCode);

        $data['records']       = (new MedicalRecordModel())->getRecentByDoctor($doctorCode);
        $data['authName']      = $doctor['Doctor_name'] ?? session()->get('name');
        $data['authCode']      = $doctorCode;
        $data['authSpec']      = $doctor['Specialization'] ?? '';
        $data['authAvailable'] = $doctor['Availability'] === 'Available';
        $data['authPhoto']     = $doctor['Photo'] ?? null;
        $data['activeNav']     = 'records';
        $data['sidebarRole']   = 'doctor';

        return view('doctor/records', $data);
    }

    public function createRecord()
    {
        $doctorCode = session()->get('code');
        $doctor     = (new DoctorModel())->find($doctorCode);
        $apptModel  = new AppointmentModel();

        $data['patients'] = $apptModel->select('appointment.Patientcode, patient.Patient_name')
            ->join('patient', 'patient.Patientcode = appointment.Patientcode')
            ->where('appointment.DoctorCode', $doctorCode)
            ->groupBy('appointment.Patientcode')
            ->findAll();

        $data['authName']      = $doctor['Doctor_name'] ?? session()->get('name');
        $data['authCode']      = $doctorCode;
        $data['authSpec']      = $doctor['Specialization'] ?? '';
        $data['authAvailable'] = $doctor['Availability'] === 'Available';
        $data['authPhoto']     = $doctor['Photo'] ?? null;
        $data['activeNav']     = 'records';
        $data['sidebarRole']   = 'doctor';

        return view('doctor/records_create', $data);
    }

    public function storeRecord()
    {
        $model = new MedicalRecordModel();

        $model->insert([
            'RecordCode'   => $model->nextCode(),
            'Visit_date'   => $this->request->getPost('Visit_date'),
            'Diagnosis'    => $this->request->getPost('Diagnosis'),
            'Treatment'    => $this->request->getPost('Treatment'),
            'Prescription' => $this->request->getPost('Prescription'),
            'DoctorCode'   => session()->get('code'),
            'Patientcode'  => $this->request->getPost('Patientcode'),
        ]);

        return redirect()->to('/doctor/records')->with('success', 'Record created successfully.');
    }

    public function editRecord($id)
    {
        $doctorCode = session()->get('code');
        $doctor     = (new DoctorModel())->find($doctorCode);

        $data['record']        = (new MedicalRecordModel())->find($id);
        $data['authName']      = $doctor['Doctor_name'] ?? session()->get('name');
        $data['authCode']      = $doctorCode;
        $data['authSpec']      = $doctor['Specialization'] ?? '';
        $data['authAvailable'] = $doctor['Availability'] === 'Available';
        $data['authPhoto']     = $doctor['Photo'] ?? null;
        $data['activeNav']     = 'records';
        $data['sidebarRole']   = 'doctor';

        return view('doctor/records_edit', $data);
    }

    public function updateRecord($id)
    {
        $model = new MedicalRecordModel();

        $model->update($id, [
            'Diagnosis'    => $this->request->getPost('Diagnosis'),
            'Treatment'    => $this->request->getPost('Treatment'),
            'Prescription' => $this->request->getPost('Prescription'),
        ]);

        return redirect()->to('/doctor/records')->with('success', 'Record updated successfully.');
    }

    public function patients()
    {
        $doctorCode = session()->get('code');
        $doctor     = (new DoctorModel())->find($doctorCode);
        $model      = new AppointmentModel();

        $data['patients'] = $model->select('patient.Patientcode, patient.Patient_name, patient.Phone, patient.Gender, COUNT(*) as visit_count')
            ->join('patient', 'patient.Patientcode = appointment.Patientcode')
            ->where('appointment.DoctorCode', $doctorCode)
            ->groupBy('appointment.Patientcode')
            ->findAll();

        $data['authName']      = $doctor['Doctor_name'] ?? session()->get('name');
        $data['authCode']      = $doctorCode;
        $data['authSpec']      = $doctor['Specialization'] ?? '';
        $data['authAvailable'] = $doctor['Availability'] === 'Available';
        $data['authPhoto']     = $doctor['Photo'] ?? null;
        $data['activeNav']     = 'patients';
        $data['sidebarRole']   = 'doctor';

        return view('doctor/patients', $data);
    }

    public function uploadPhoto()
    {
        $doctorCode = session()->get('code');
        $model      = new DoctorModel();
        $doctor     = $model->find($doctorCode);
        $file       = $this->request->getFile('photo');
        $dir        = FCPATH . 'uploads/avatars/';

        if ($file->isValid() && !$file->hasMoved()
            && in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'], true)
            && $file->getSize() <= 2 * 1024 * 1024
        ) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $old = $doctor['Photo'] ?? null;
            if ($old && file_exists($dir . $old)) {
                unlink($dir . $old);
            }

            $filename = 'doctor_' . $doctorCode . '_' . time() . '.' . $file->guessExtension();
            $file->move($dir, $filename);
            $model->update($doctorCode, ['Photo' => $filename]);
        }

        return redirect()->to('/doctor/profile')->with('success', 'Photo updated.');
    }

    public function profile()
    {
        $doctorCode = session()->get('code');
        $doctor     = (new DoctorModel())->find($doctorCode);

        $data['doctor']        = $doctor;
        $data['authName']      = $doctor['Doctor_name'] ?? session()->get('name');
        $data['authCode']      = $doctorCode;
        $data['authSpec']      = $doctor['Specialization'] ?? '';
        $data['authAvailable'] = $doctor['Availability'] === 'Available';
        $data['authPhoto']     = $doctor['Photo'] ?? null;
        $data['activeNav']     = 'profile';
        $data['sidebarRole']   = 'doctor';

        return view('doctor/profile', $data);
    }
}
