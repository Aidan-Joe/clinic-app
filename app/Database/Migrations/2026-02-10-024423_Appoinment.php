<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Appointment extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Appointmentcode' => ['type' => 'VARCHAR', 'constraint' => 5],
            'Patientcode' => ['type' => 'VARCHAR', 'constraint' => 5],
            'DoctorCode' => ['type' => 'VARCHAR', 'constraint' => 5],
            'AdminCode' => ['type' => 'VARCHAR', 'constraint' => 5],
            'RecordCode' => ['type' => 'VARCHAR', 'constraint' => 5],
            'Room_Code' => ['type' => 'INT', 'constraint' => 5],
            'Diagnosis' => ['type' => 'VARCHAR', 'constraint' => 255],
            'Treatment' => ['type' => 'VARCHAR', 'constraint' => 255],
        ]);

        $this->forge->addKey('Appointmentcode', true);
        $this->forge->addForeignKey('Patientcode', 'patient', 'Patientcode', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('DoctorCode', 'doctor', 'DoctorCode', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('AdminCode', 'admin', 'AdminCode', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('RecordCode', 'medicalrecord', 'RecordCode', 'CASCADE', 'CASCADE');
        $this->forge->createTable('appointment', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('appointment');
    }
}

