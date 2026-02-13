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
        // Simple data for testing the view
        $data = [
            'authName' => 'Dr. Hendra Wijaya',
            'authCode' => 'DC001',
            'authSpec' => 'Cardiology',
            'authAvailable' => 'Available',
            'notifCount' => 3,
        ];
        
        return view('doctor_view', $data);
        $doctorCode = session()->get('DoctorCode'); 

        $appointmentModel = new AppointmentModel();
        $recordModel      = new MedicalRecordModel();
        $roomModel        = new RoomModel();

        $today = date('Y-m-d');

        $data['stats'] = [
            'appointments_today' => $appointmentModel
                ->where('DoctorCode', $doctorCode)
                ->where('Appointment_date', $today)
                ->countAllResults(),

            'completed' => $appointmentModel
                ->where('DoctorCode', $doctorCode)
                ->where('Status', 'completed')
                ->countAllResults(),

            'total_patients' => $appointmentModel
                ->where('DoctorCode', $doctorCode)
                ->distinct()
                ->countAllResults('Patientcode'),

            'records_pending' => 0
        ];

        $data['queue'] = $appointmentModel
            ->where('DoctorCode', $doctorCode)
            ->where('Appointment_date', $today)
            ->findAll();

        $data['recentRecords'] = $recordModel
            ->orderBy('Visit_date', 'DESC')
            ->findAll(5);

        $data['myRoom'] = $roomModel
            ->where('Status', 'Occupied')
            ->first();

        return view('doctor/index', $data);
    }

    public function updateAvailability($id)
    {
        $model = new DoctorModel();

        $model->update($id, [
            'Availability' => $this->request->getPost('Availability')
        ]);

        return redirect()->back()->with('success', 'Status availability updated');
    }
}
