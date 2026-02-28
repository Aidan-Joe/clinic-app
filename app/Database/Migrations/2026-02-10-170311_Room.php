<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RoomCode extends Migration
{
    public function up() {
        $this->forge->addField([
            'Room_Code' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => FALSE],
            'Room_Name' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
            'Room_Type' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
            'Status' => ['type' => 'ENUM', 'constraint' => ['Available', 'Occupied'], 'null' => FALSE],
        ]);
        $this->forge->addKey('Room_Code', true);
        $this->forge->createTable('room', true, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        $this->forge->dropTable('room');
    }
}
