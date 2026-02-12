<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run()
    {
       
        $faker = \Faker\Factory::create('id_ID');

        $specializations = [
            'General Practitioner',
            'Pediatrician',
            'Cardiologist',
            'Dermatologist',
            'Neurologist',
            'Orthopedic',
            'Dentist',
            'Psychiatrist'
        ];

        for ($i = 1; $i <= 20; $i++) {

            $data = [
                'DoctorCode'      => 'D' . str_pad($i, 4, '0', STR_PAD_LEFT), // D0001
                'Doctor_name'     => $faker->name(),
                'Specialization'  => $faker->randomElement($specializations),
                'Doctor_email'    => $faker->unique()->safeEmail(),
                'Phone'           => '08' . $faker->numerify('##########'),
                'Availability'    => $faker->randomElement(['Available', 'Not Available']),
            ];

            $this->db->table('doctor')->insert($data);
        }
    }
}