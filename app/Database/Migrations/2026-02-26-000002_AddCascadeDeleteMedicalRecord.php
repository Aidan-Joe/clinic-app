<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCascadeDeleteMedicalRecord extends Migration
{
    public function up()
    {
        // Delete any medical records whose Patientcode or DoctorCode no longer
        // exists in the parent table — otherwise MySQL refuses to add the FK
        $this->db->query('
            DELETE FROM medicalrecord
            WHERE Patientcode IS NOT NULL
              AND Patientcode NOT IN (SELECT Patientcode FROM patient)
        ');

        $this->db->query('
            UPDATE medicalrecord
            SET DoctorCode = NULL
            WHERE DoctorCode IS NOT NULL
              AND DoctorCode NOT IN (SELECT DoctorCode FROM doctor)
        ');

        // FK on Patientcode: deleting a patient cascades to their records
        $this->db->query('
            ALTER TABLE medicalrecord
            ADD CONSTRAINT fk_medicalrecord_patient
            FOREIGN KEY (Patientcode)
            REFERENCES patient(Patientcode)
            ON DELETE CASCADE
            ON UPDATE CASCADE
        ');

        // FK on DoctorCode: deleting a doctor nullifies the reference, keeps the record
        $this->db->query('
            ALTER TABLE medicalrecord
            ADD CONSTRAINT fk_medicalrecord_doctor
            FOREIGN KEY (DoctorCode)
            REFERENCES doctor(DoctorCode)
            ON DELETE SET NULL
            ON UPDATE CASCADE
        ');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE medicalrecord DROP FOREIGN KEY fk_medicalrecord_patient');
        $this->db->query('ALTER TABLE medicalrecord DROP FOREIGN KEY fk_medicalrecord_doctor');
    }
}
