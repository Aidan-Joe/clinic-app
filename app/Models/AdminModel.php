<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'AdminCode';
    protected $allowedFields = [
        'AdminCode',
        'DoctorCode',
        'Admin_name',
        'Admin_email',
        'Password'
    ];
}
