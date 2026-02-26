<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Doctor extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'DoctorCode' => ['type' => 'VARCHAR', 'constraint' => 5],
            'Doctor_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'Specialization' => ['type' => 'VARCHAR', 'constraint' => 100],
            'Doctor_email' => ['type' => 'VARCHAR', 'constraint' => 100],
            'Phone' => ['type' => 'VARCHAR', 'constraint' => 15],
            'Availability' => ['type' => 'ENUM', 'constraint' => ['Available', 'Not Available']],
        ]);

        $this->forge->addKey('DoctorCode', true);

        $this->forge->createTable('doctor', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('doctor');
    }
}

