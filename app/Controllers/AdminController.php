<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;
use App\Models\RoomModel;

class AdminController extends BaseController
{
    public function index()
    {
        // Simple data for testing the view
        $data = [
            'authName' => 'Admin User',
            'authCode' => 'ADM001',
            'notifCount' => 5,
        ];
         return view('admin_view', $data);
        $patientModel     = new PatientModel();
        $doctorModel      = new DoctorModel();
        $appointmentModel = new AppointmentModel();
        $roomModel        = new RoomModel();

        // Statistik
        $data['stats'] = [
            'patients'            => $patientModel->countAll(),
            'doctors'             => $doctorModel->countAll(),
            'appointments_today'  => $appointmentModel
                                        ->where('Appointment_date', date('Y-m-d'))
                                        ->countAllResults(),
            'rooms_available'     => $roomModel
                                        ->where('Status', 'Available')
                                        ->countAllResults(),
        ];

        // Today's appointments
        $data['appointments'] = $appointmentModel
            ->where('Appointment_date', date('Y-m-d'))
            ->findAll();

        $data['doctors'] = $doctorModel->findAll();
        $data['rooms']   = $roomModel->findAll();
        return view('admin/index', $data);
       
    }
}
