<?php

namespace App\Imports;

use App\Models\Applicant;
use App\Models\Aptitude;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AptitudeImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    // public function model(array $row)
    // {
    //     return new Aptitude([
    //         'applicant_id' => Applicant::where('applicant_serial_number', $row['applicant_serial_number'])->first()->id ?? null,
    //         'aptitude_status' => $row['aptitude_status'],
    //         'aptitude_marks' => $row['aptitude_marks'],
    //     ]);
    // }

    public function model(array $row)
    {
        $applicant = Applicant::where('applicant_serial_number', $row['applicant_serial_number'])->first();
        if ($applicant) {
            $aptitude = new Aptitude([
                'applicant_id' => $applicant->id,
                'aptitude_status' => $row['aptitude_status'],
                'aptitude_marks' => $row['aptitude_marks'],
            ]);
            if ($row['aptitude_status'] === 'QUALIFIED') {
                BasicFitness::updateOrCreate(
                    ['applicant_id' => $applicant->id],
                );
            }
            return $aptitude;
        }
        return null;
    }
}
