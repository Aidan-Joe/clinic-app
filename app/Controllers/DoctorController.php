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

        $data['stats'] = [
            'appointments_today' => $appointmentModel->countTodayByDoctor($doctorCode),
            'completed'          => $appointmentModel->countCompletedByDoctor($doctorCode),
            'total_patients'     => $appointmentModel->countTotalPatientsByDoctor($doctorCode),
            'records_pending'    => $medicalRecordModel->countPendingByDoctor($doctorCode),
        ];

        $queue               = $appointmentModel->getTodayQueueByDoctor($doctorCode);
        $data['queue']       = $queue;
        $data['nextPatient'] = !empty($queue) ? $queue[0] : null;
        $data['recentRecords'] = $medicalRecordModel->getRecentByDoctor($doctorCode);
        $firstAppt = !empty($queue) ? $queue[0] : null;
        $data['myRoom'] = ($firstAppt && !empty($firstAppt['Room_Code']))
            ? $roomModel->find($firstAppt['Room_Code'])
            : null;

        $data = array_merge($data, $this->authData());

        return view('doctor_view', $data);
    }

private function authData(): array
{
    $doctorCode = session()->get('code');
    $doctor     = (new DoctorModel())->find($doctorCode);
    $segment   = service('request')->getUri()->getSegment(2) ?: 'dashboard';
    $activeNav = $segment;

    return [
        'authName'      => $doctor['Doctor_name']    ?? session()->get('name'),
        'authCode'      => $doctorCode,
        'authSpec'      => $doctor['Specialization']  ?? '',
        'authAvailable' => ($doctor['Availability']   ?? '') === 'Available',
        'activeNav'     => $activeNav,
        'sidebarRole'   => 'doctor', 
    ];
}

    public function updateAvailability()
    {
        $model      = new DoctorModel();
        $doctorCode = session()->get('code');
        $doctor     = $model->find($doctorCode);

        $newStatus = $doctor['Availability'] === 'Available' ? 'Not Available' : 'Available';
        $model->update($doctorCode, ['Availability' => $newStatus]);

        return redirect()->back();
    }

    public function appointments()
    {
        $doctorCode = session()->get('code');
        $model      = new AppointmentModel();

        $data['appointments'] = $model->select('appointment.*, patient.Patient_name')
            ->join('patient', 'patient.Patientcode = appointment.Patientcode', 'left')
            ->where('appointment.DoctorCode', $doctorCode)
            ->orderBy('Appointment_date', 'DESC')
            ->findAll();

        $data = array_merge($data, $this->authData());

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
        $model      = new MedicalRecordModel();

        $data['records']      = $model->getRecentByDoctor($doctorCode);
        $data = array_merge($data, $this->authData());

        return view('doctor/records', $data);
    }

    public function createRecord()
    {
        $doctorCode = session()->get('code');
        $apptModel  = new AppointmentModel();

                $data['patients']     = $apptModel->select('appointment.Patientcode, patient.Patient_name')
            ->join('patient', 'patient.Patientcode = appointment.Patientcode')
            ->where('appointment.DoctorCode', $doctorCode)
            ->groupBy('appointment.Patientcode')
            ->findAll();

        $data = array_merge($data, $this->authData());

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
        $model = new MedicalRecordModel();
        $data['record']      = $model->find($id);
        $data = array_merge($data, $this->authData());

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
        $model      = new AppointmentModel();

        $rows = $model->select('patient.Patientcode, patient.Patient_name, patient.Phone, patient.Gender, COUNT(*) as visit_count')
            ->join('patient', 'patient.Patientcode = appointment.Patientcode')
            ->where('appointment.DoctorCode', $doctorCode)
            ->groupBy('appointment.Patientcode')
            ->findAll();

        $data['patients']     = $rows;
        $data = array_merge($data, $this->authData());

        return view('doctor/patients', $data);
    }

    public function profile()
    {
        $doctorCode = session()->get('code');
        $model      = new DoctorModel();
        $doctor     = $model->find($doctorCode);

        $data['doctor']       = $doctor;
        $data = array_merge($data, $this->authData());

        return view('doctor/profile', $data);
    }
}
