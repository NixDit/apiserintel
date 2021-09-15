<?php

namespace App\Exports;

use App\Exports\EmployeeSalesReportExport;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EmployeeSalesReportExportSheet implements WithMultipleSheets
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->data as $key => $value) {
            $sheets[] = new EmployeeSalesReportExport($value);
        }
        return $sheets;
    }
}