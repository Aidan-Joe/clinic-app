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
        $model = new PatientModel();
        $data['patients'] = $model->findAll();

        return view('patient/index', $data);
    }

    public function create()
    {
        return view('patient/create');
    }

    public function store()
    {
        $model = new PatientModel();

        $model->insert([
            'Patientcode' => $this->request->getPost('Patientcode'),
            'Patient_name'=> $this->request->getPost('Patient_name'),
            'Gender'      => $this->request->getPost('Gender'),
            'Phone'       => $this->request->getPost('Phone'),
            'Patient_email'=> $this->request->getPost('Patient_email'),
            'Address'     => $this->request->getPost('Address'),
        ]);

        return redirect()->to('/patient')->with('success','Patient created');
    }

    public function edit($id)
    {
        $model = new PatientModel();
        $data['patient'] = $model->find($id);

        return view('patient/edit', $data);
    }

    public function update($id)
    {
        $model = new PatientModel();

        $model->update($id, [
            'Patient_name'=> $this->request->getPost('Patient_name'),
            'Gender'      => $this->request->getPost('Gender'),
            'Phone'       => $this->request->getPost('Phone'),
            'Patient_email'=> $this->request->getPost('Patient_email'),
            'Address'     => $this->request->getPost('Address'),
        ]);

        return redirect()->to('/patient')->with('success','Patient updated');
    }

    public function delete($id)
    {
        $model = new PatientModel();
        $model->delete($id);

        return redirect()->to('/patient')->with('success','Patient deleted');
    }
}
