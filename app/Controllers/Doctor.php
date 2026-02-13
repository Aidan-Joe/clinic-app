<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Doctor extends BaseController
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
    }
}
