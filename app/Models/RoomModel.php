<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table = 'room';
    protected $primaryKey = 'Room_Code';

    protected $allowedFields = [
        'Room_Code',
        'Room_Name',
        'Room_Type',
        'Status'
    ];

    protected $useTimestamps = false;
}
