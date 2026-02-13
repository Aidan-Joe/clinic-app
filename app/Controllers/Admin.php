<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
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
    }
}
