<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MedicalRecordModel;

class MedicalRecordController extends BaseController
{
    public function index()
    {
        $model = new MedicalRecordModel();
        $data['records'] = $model->findAll();

        return view('medicalrecord/index', $data);
    }

    public function store()
    {
        $model = new MedicalRecordModel();

        $model->save([
            'RecordCode' => $this->request->getPost('RecordCode'),
            'Visit_date' => $this->request->getPost('Visit_date'),
            'Diagnosis' => $this->request->getPost('Diagnosis'),
            'Treatment' => $this->request->getPost('Treatment'),
            'Prescription' => $this->request->getPost('Prescription'),
        ]);

        return redirect()->back()->with('success', 'Medical record saved');
    }
}
