<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class StudentsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Retrieve the students data and map it to the desired format
        return Student::all()->map(function ($student) {
            // Check if transactions are not null and not empty
            $transactionDate = optional($student->transactions)->isNotEmpty() ? $student->transactions->first()->date : 'N/A';
            $transactionAmount = optional($student->transactions)->isNotEmpty() ? $student->transactions->first()->amount : 'N/A';
            // Check if services are not null and not empty
            $serviceName = optional($student->services)->isNotEmpty() ? $student->services->first()->servicename : 'N/A';
            $serviceQuantity = optional($student->services)->isNotEmpty() ? $student->services->first()->quantity : 'N/A';

            return [
                'Student Name' => $student->name,
                'Roll Number' => $student->rollnumber,
                'Mobile Number' => $student->mobile_number,
                'Balance' => $student->balance,
                'Department Name' => $student->department->department_name ?? 'N/A',
                'Transaction Date' => $transactionDate,
                'Transaction Amount' => $transactionAmount,
                'Service Name' => $serviceName,
                'Service Quantity' => $serviceQuantity,
            ];
        });
    }


    /**
     * @return array
     */
    public function headings(): array
    {
        // Define the column headings
        return [
            'Student Name',
            'Roll Number',
            'Mobile Number',
            'Balance',
            'Department Name',
            'Transaction Date',
            'Transaction Amount',
            'Service Name',
            'Service Quantity',
        ];
    }
}
