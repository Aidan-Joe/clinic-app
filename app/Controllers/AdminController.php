<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;
use App\Models\RoomModel;
use App\Models\MedicalRecordModel;

class AdminController extends BaseController
{

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

        $data['appointments'] = $appointmentModel->getTodayFullAppointments();
        $data['doctors']      = $doctorModel->findAll();
        $data['rooms']        = $roomModel->findAll();
        $data['authName']     = session()->get('name');
        $data['authCode']     = session()->get('code');

        return view('admin_view', $data);
    }

    public function doctors()
    {
        $model = new DoctorModel();
        $data['doctors']  = $model->findAll();
        $data['authName'] = session()->get('name');
        $data['authCode'] = session()->get('code');

        return view('admin/doctors/index', $data);
    }

    public function createDoctor()
    {
        $data['authName'] = session()->get('name');
        $data['authCode'] = session()->get('code');
        return view('admin/doctors/create', $data);
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
            'Availability'   => 'Available',
        ]);

        return redirect()->to('/admin/doctors')->with('success', 'Doctor created successfully.');
    }

    public function editDoctor($id)
    {
        $model = new DoctorModel();
        $data['doctor']   = $model->find($id);
        $data['authName'] = session()->get('name');
        $data['authCode'] = session()->get('code');

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

        return redirect()->to('/admin/doctors')->with('success', 'Doctor updated successfully.');
    }

    public function deleteDoctor($id)
    {
        $model = new DoctorModel();
        $model->delete($id);

        return redirect()->to('/admin/doctors')->with('success', 'Doctor deleted.');
    }

    public function patients()
    {
        $model = new PatientModel();
        $data['patients'] = $model->findAll();
        $data['authName'] = session()->get('name');
        $data['authCode'] = session()->get('code');

        return view('admin/patients/index', $data);
    }

    public function createPatient()
    {
        $data['authName'] = session()->get('name');
        $data['authCode'] = session()->get('code');
        return view('admin/patients/create', $data);
    }

    public function storePatient()
    {
        $model = new PatientModel();

        $model->insert([
            'Patientcode'   => $this->request->getPost('Patientcode'),
            'Patient_name'  => $this->request->getPost('Patient_name'),
            'Patient_email' => $this->request->getPost('Patient_email'),
            'Password'      => password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT),
            'Phone'         => $this->request->getPost('Phone'),
            'Birthdate'     => $this->request->getPost('Birthdate'),
            'Gender'        => $this->request->getPost('Gender'),
            'Address'       => $this->request->getPost('Address'),
        ]);

        return redirect()->to('/admin/patients')->with('success', 'Patient created successfully.');
    }

    public function editPatient($id)
    {
        $model = new PatientModel();
        $data['patient']  = $model->find($id);
        $data['authName'] = session()->get('name');
        $data['authCode'] = session()->get('code');

        return view('admin/patients/edit', $data);
    }

    public function updatePatient($id)
    {
        $model = new PatientModel();

        $model->update($id, [
            'Patient_name'  => $this->request->getPost('Patient_name'),
            'Patient_email' => $this->request->getPost('Patient_email'),
            'Phone'         => $this->request->getPost('Phone'),
            'Birthdate'     => $this->request->getPost('Birthdate'),
            'Gender'        => $this->request->getPost('Gender'),
            'Address'       => $this->request->getPost('Address'),
        ]);

        return redirect()->to('/admin/patients')->with('success', 'Patient updated successfully.');
    }

    public function deletePatient($id)
    {
        $model = new PatientModel();
        $model->delete($id);

        return redirect()->to('/admin/patients')->with('success', 'Patient deleted.');
    }

    public function appointments()
    {
        $appointmentModel = new AppointmentModel();
        $data['appointments'] = $appointmentModel->getAllFullAppointments();
        $data['authName']     = session()->get('name');
        $data['authCode']     = session()->get('code');

        return view('admin/appointments/index', $data);
    }

    public function createAppointment()
    {
        $data['patients'] = (new PatientModel())->findAll();
        $data['doctors']  = (new DoctorModel())->findAll();
        $data['rooms']    = (new RoomModel())->findAll();
        $data['authName'] = session()->get('name');
        $data['authCode'] = session()->get('code');

        return view('admin/appointments/create', $data);
    }

    public function storeAppointment()
    {
        $model = new AppointmentModel();

        $model->insert([
            'Appointmentcode'  => $model->nextCode(),
            'Patientcode'      => $this->request->getPost('Patientcode'),
            'DoctorCode'       => $this->request->getPost('DoctorCode'),
            'Room_Code'        => $this->request->getPost('Room_Code') ?: null,
            'Appointment_date' => $this->request->getPost('Appointment_date'),
            'Appointment_time' => $this->request->getPost('Appointment_time'),
            'Symptoms'         => $this->request->getPost('Symptoms'),
            'Status'           => 'scheduled',
        ]);

        return redirect()->to('/admin/appointments')->with('success', 'Appointment created successfully.');
    }

    public function editAppointment($id)
    {
        $model = new AppointmentModel();
        $data['appointment'] = $model->find($id);
        $data['patients']    = (new PatientModel())->findAll();
        $data['doctors']     = (new DoctorModel())->findAll();
        $data['rooms']       = (new RoomModel())->findAll();
        $data['authName']    = session()->get('name');
        $data['authCode']    = session()->get('code');

        return view('admin/appointments/edit', $data);
    }

    public function updateAppointment($id)
    {
        $model = new AppointmentModel();

        $model->update($id, [
            'DoctorCode'       => $this->request->getPost('DoctorCode'),
            'Room_Code'        => $this->request->getPost('Room_Code'),
            'Appointment_date' => $this->request->getPost('Appointment_date'),
            'Appointment_time' => $this->request->getPost('Appointment_time'),
            'Symptoms'         => $this->request->getPost('Symptoms'),
            'Status'           => $this->request->getPost('Status'),
        ]);

        return redirect()->to('/admin/appointments')->with('success', 'Appointment updated successfully.');
    }

    public function deleteAppointment($id)
    {
        $model = new AppointmentModel();
        $model->delete($id);

        return redirect()->to('/admin/appointments')->with('success', 'Appointment deleted.');
    }

    public function rooms()
    {
        $model = new RoomModel();
        $data['rooms']    = $model->findAll();
        $data['authName'] = session()->get('name');
        $data['authCode'] = session()->get('code');

        return view('admin/rooms/index', $data);
    }

    public function createRoom()
    {
        $data['authName'] = session()->get('name');
        $data['authCode'] = session()->get('code');
        return view('admin/rooms/create', $data);
    }

    public function storeRoom()
    {
        $model = new RoomModel();

        $model->insert([
            'Room_Code' => $this->request->getPost('Room_Code'),
            'Room_Name' => $this->request->getPost('Room_Name'),
            'Room_Type' => $this->request->getPost('Room_Type'),
            'Status'    => 'Available',
        ]);

        return redirect()->to('/admin/rooms')->with('success', 'Room created successfully.');
    }

    public function editRoom($id)
    {
        $model = new RoomModel();
        $data['room']     = $model->find($id);
        $data['authName'] = session()->get('name');
        $data['authCode'] = session()->get('code');

        return view('admin/rooms/edit', $data);
    }

    public function updateRoom($id)
    {
        $model = new RoomModel();

        $model->update($id, [
            'Room_Name' => $this->request->getPost('Room_Name'),
            'Room_Type' => $this->request->getPost('Room_Type'),
            'Status'    => $this->request->getPost('Status'),
        ]);

        return redirect()->to('/admin/rooms')->with('success', 'Room updated successfully.');
    }

    public function deleteRoom($id)
    {
        $model = new RoomModel();
        $model->delete($id);

        return redirect()->to('/admin/rooms')->with('success', 'Room deleted.');
    }

    public function records()
    {
        $model = new MedicalRecordModel();
        $data['records']  = $model->getWithRelation();
        $data['authName'] = session()->get('name');
        $data['authCode'] = session()->get('code');

        return view('admin/records/index', $data);
    }

    public function createRecord()
    {
        $data['doctors']  = (new DoctorModel())->findAll();
        $data['patients'] = (new PatientModel())->findAll();
        $data['authName'] = session()->get('name');
        $data['authCode'] = session()->get('code');

        return view('admin/records/create', $data);
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
            'DoctorCode'   => $this->request->getPost('DoctorCode'),
            'Patientcode'  => $this->request->getPost('Patientcode'),
        ]);

        return redirect()->to('/admin/records')->with('success', 'Record created successfully.');
    }

    public function editRecord($id)
    {
        $model = new MedicalRecordModel();
        $data['record']   = $model->find($id);
        $data['doctors']  = (new DoctorModel())->findAll();
        $data['patients'] = (new PatientModel())->findAll();
        $data['authName'] = session()->get('name');
        $data['authCode'] = session()->get('code');

        return view('admin/records/edit', $data);
    }

    public function updateRecord($id)
    {
        $model = new MedicalRecordModel();

        $model->update($id, [
            'Diagnosis'    => $this->request->getPost('Diagnosis'),
            'Treatment'    => $this->request->getPost('Treatment'),
            'Prescription' => $this->request->getPost('Prescription'),
            'DoctorCode'   => $this->request->getPost('DoctorCode'),
            'Patientcode'  => $this->request->getPost('Patientcode'),
        ]);

        return redirect()->to('/admin/records')->with('success', 'Record updated successfully.');
    }

    public function deleteRecord($id)
    {
        $model = new MedicalRecordModel();
        $model->delete($id);

        return redirect()->to('/admin/records')->with('success', 'Record deleted.');
    }
}
