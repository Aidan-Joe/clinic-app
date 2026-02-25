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
    public function getCurrentRoomByDoctor($doctorCode)
    {
        return $this->where('Status', 'Occupied')
            ->first();
    }
    public function countAvailable()
    {
        return $this->where('Status', 'Available')
            ->countAllResults();
    }
    protected $useTimestamps = false;
}
