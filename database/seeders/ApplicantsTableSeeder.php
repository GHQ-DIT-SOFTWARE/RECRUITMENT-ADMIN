<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApplicantsTableSeeder extends Seeder
{
    private $sequence = 1; // Initialize sequence

    /**
     * Run the database seeds.
     */
    // public function run()
    // {
    //     $applicants = [];
    //     for ($i = 0; $i < 10000; $i++) { // Adjust loop to 10,000 iterations
    //         $applicants[] = [
    //             'uuid' => (string) Str::uuid(),
    //             'serial_number' => $this->generateSerialNumber(),
    //             'pincode' => $this->generatePinCode(),
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ];
    //     }
    //     DB::table('cards')->insert($applicants);
    // }
    public function run()
    {
        $batchSize = 500; // Adjust the batch size
        $applicants = [];

        for ($i = 0; $i < 10000; $i++) {
            $applicants[] = [
                'uuid' => (string) Str::uuid(),
                'serial_number' => $this->generateSerialNumber(),
                'pincode' => $this->generatePinCode(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert the batch when it reaches the batch size
            if (count($applicants) === $batchSize) {
                DB::table('cards')->insert($applicants);
                $applicants = []; // Reset the array for the next batch
            }
        }

        // Insert any remaining records
        if (!empty($applicants)) {
            DB::table('cards')->insert($applicants);
        }
    }
    /**
     * Generate a serial number with random alphanumeric prefix and sequential suffix.
     *
     * @return string
     */
    private function generateSerialNumber()
    {
        $prefix = $this->generateRandomAlphanumeric(7); // Generate 7-character alphanumeric prefix
        $sequenceNumber = str_pad($this->sequence, 3, '0', STR_PAD_LEFT); // Sequential number padded to 3 digits
        $this->sequence++;
        return $prefix . $sequenceNumber;
    }

    /**
     * Generate a random alphanumeric string of given length.
     *
     * @param int $length
     * @return string
     */
    private function generateRandomAlphanumeric($length)
    {
        // Exclude lowercase 'i', 'l', and the digit '0'
        $characters = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz123456789';
        return substr(str_shuffle($characters), 0, $length);
    }

    /**
     * Generate a random pin code.
     *
     * @return string
     */
    private function generatePinCode()
    {
        return substr(str_shuffle(str_repeat('123456789', 12)), 0, 12); // Exclude '0' from the pincode
    }

    /**
     * Generate a random string for the surname field.
     *
     * @return string
     */
    private function generateRandomString()
    {
        $length = rand(5, 10);
        return Str::random($length);
    }
}
