<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Patient extends BaseController
{
   public function index()
    {
        // Simple data for testing the view
        $data = [
            'authName' => 'Rina Ayu Lestari',
            'authCode' => 'PT001',
            'notifCount' => 3,
        ];
        
        return view('patient_view', $data);
    }
}
