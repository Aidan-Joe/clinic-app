<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Admin extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'AdminCode' => ['type' => 'VARCHAR', 'constraint' => 5],
            'DoctorCode' => ['type' => 'VARCHAR', 'constraint' => 5],
            'Admin_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'Admin_email' => ['type' => 'VARCHAR', 'constraint' => 100],
            'Password' => ['type' => 'VARCHAR', 'constraint' => 255],
        ]);

        $this->forge->addKey('AdminCode', true);
         $this->forge->addForeignKey('DoctorCode', 'doctor', 'DoctorCode', 'CASCADE', 'CASCADE');
        $this->forge->createTable('admin', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('admin');
    }
}

