<?php

namespace App\Imports;

use App\Models\PersonalDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StudentsImport implements ToModel, WithHeadingRow, WithStartRow
{
    private $currentCourse = null; 

    private $centre; // Add a property for centre

    public function startRow(): int
    {
        return 1; // Specify the starting row number
    }
    public function __construct($centre)
    {
        $this->centre = $centre; // Assign the centre value
    }

    public function model(array $row)
    {
        if (!isset($row['name']) || is_null($row['adm_no'])) {
            $this->currentCourse = $row['name']; // Update the current course
            return null; // Skip this row
        }
        return new PersonalDetail([
            'matric_number' => $row['adm_no'],
            'application_number' => $row['adm_no'],
            'other_names' => $row['name'],
            'course' => $this->currentCourse, // Assign the current course
            'desired_study_cent' => $this->centre, // Assign the current course
            'has_admission' => true, // Assign the current course
        ]);

    }
}