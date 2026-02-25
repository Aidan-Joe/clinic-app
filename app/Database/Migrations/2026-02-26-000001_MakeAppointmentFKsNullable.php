<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeAppointmentFKsNullable extends Migration
{
    public function up()
    {
        // Drop existing FK constraints before modifying columns
        $this->db->query('ALTER TABLE appointment DROP FOREIGN KEY appointment_RecordCode_foreign');
        $this->db->query('ALTER TABLE appointment DROP FOREIGN KEY appointment_AdminCode_foreign');
        $this->db->query('ALTER TABLE appointment DROP FOREIGN KEY fk_room_code');

        $this->forge->modifyColumn('appointment', [
            'RecordCode' => [
                'type'       => 'VARCHAR',
                'constraint' => 5,
                'null'       => true,
                'default'    => null,
            ],
            'AdminCode' => [
                'type'       => 'VARCHAR',
                'constraint' => 5,
                'null'       => true,
                'default'    => null,
            ],
            'Room_Code' => [
                'type'       => 'VARCHAR',
                'constraint' => 5,
                'null'       => true,
                'default'    => null,
            ],
        ]);

        // Re-add FKs allowing NULL values
        $this->db->query('ALTER TABLE appointment ADD CONSTRAINT appointment_RecordCode_foreign FOREIGN KEY (RecordCode) REFERENCES medicalrecord(RecordCode) ON DELETE SET NULL ON UPDATE CASCADE');
        $this->db->query('ALTER TABLE appointment ADD CONSTRAINT appointment_AdminCode_foreign  FOREIGN KEY (AdminCode)  REFERENCES admin(AdminCode)         ON DELETE SET NULL ON UPDATE CASCADE');
        $this->db->query('ALTER TABLE appointment ADD CONSTRAINT fk_room_code                  FOREIGN KEY (Room_Code)  REFERENCES room(Room_Code)           ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE appointment DROP FOREIGN KEY appointment_RecordCode_foreign');
        $this->db->query('ALTER TABLE appointment DROP FOREIGN KEY appointment_AdminCode_foreign');
        $this->db->query('ALTER TABLE appointment DROP FOREIGN KEY fk_room_code');

        $this->forge->modifyColumn('appointment', [
            'RecordCode' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => false],
            'AdminCode'  => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => false],
            'Room_Code'  => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => false],
        ]);

        $this->db->query('ALTER TABLE appointment ADD CONSTRAINT appointment_RecordCode_foreign FOREIGN KEY (RecordCode) REFERENCES medicalrecord(RecordCode) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->db->query('ALTER TABLE appointment ADD CONSTRAINT appointment_AdminCode_foreign  FOREIGN KEY (AdminCode)  REFERENCES admin(AdminCode)          ON DELETE CASCADE ON UPDATE CASCADE');
        $this->db->query('ALTER TABLE appointment ADD CONSTRAINT fk_room_code                  FOREIGN KEY (Room_Code)  REFERENCES room(Room_Code)            ON DELETE CASCADE ON UPDATE CASCADE');
    }
}
