<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MedicalRecordModel;
use App\Models\DoctorModel;
use App\Models\PatientModel;

class MedicalRecordController extends BaseController
{
    public function index()
    {
        $model = new MedicalRecordModel();
        $data['records'] = $model->getWithRelation();

        return view('medicalrecord/index', $data);
    }

    public function create()
    {
        $doctorModel  = new DoctorModel();
        $patientModel = new PatientModel();

        $data['doctors']  = $doctorModel->findAll();
        $data['patients'] = $patientModel->findAll();

        return view('medicalrecord/create', $data);
    }

    public function store()
    {
        $model = new MedicalRecordModel();

        $model->insert([
            'RecordCode'  => 'REC' . rand(1000,9999),
            'Visit_date'  => $this->request->getPost('Visit_date'),
            'Diagnosis'   => $this->request->getPost('Diagnosis'),
            'Treatment'   => $this->request->getPost('Treatment'),
            'Prescription'=> $this->request->getPost('Prescription'),
            'DoctorCode'  => $this->request->getPost('DoctorCode'),
            'Patientcode' => $this->request->getPost('Patientcode'),
        ]);

        return redirect()->to('/medicalrecord')->with('success','Record created');
    }

    public function edit($id)
    {
        $model = new MedicalRecordModel();
        $data['record'] = $model->find($id);

        return view('medicalrecord/edit', $data);
    }

    public function update($id)
    {
        $model = new MedicalRecordModel();

        $model->update($id, [
            'Diagnosis'    => $this->request->getPost('Diagnosis'),
            'Treatment'    => $this->request->getPost('Treatment'),
            'Prescription' => $this->request->getPost('Prescription'),
        ]);

        return redirect()->to('/medicalrecord')->with('success','Record updated');
    }

    public function delete($id)
    {
        $model = new MedicalRecordModel();
        $model->delete($id);

        return redirect()->to('/medicalrecord')->with('success','Record deleted');
    }
}