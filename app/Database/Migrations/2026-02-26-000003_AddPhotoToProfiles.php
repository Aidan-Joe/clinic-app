<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPhotoToProfiles extends Migration
{
    public function up()
    {
        $this->forge->addColumn('doctor', [
            'Photo' => [
                'type'    => 'VARCHAR',
                'constraint' => 255,
                'null'    => true,
                'default' => null,
                'after'   => 'Phone',
            ],
        ]);

        $this->forge->addColumn('patient', [
            'Photo' => [
                'type'    => 'VARCHAR',
                'constraint' => 255,
                'null'    => true,
                'default' => null,
                'after'   => 'Address',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('doctor',  'Photo');
        $this->forge->dropColumn('patient', 'Photo');
    }
}
