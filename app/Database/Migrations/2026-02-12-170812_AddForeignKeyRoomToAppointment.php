<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeyRoomToAppointment extends Migration
{
    public function up() {

        $this->forge->modifyColumn('appointment', [
            'Room_Code' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => FALSE,
            ]
        ]);

        $this->db->query("
            ALTER TABLE appointment
            ADD CONSTRAINT fk_room_code
            FOREIGN KEY (Room_Code)
            REFERENCES Room(Room_Code)
            ON DELETE CASCADE
            ON UPDATE CASCADE
        ");
    }

    public function down() {

        $this->db->query("
            ALTER TABLE appointment
            DROP FOREIGN KEY fk_room_code
        ");
    }
}
