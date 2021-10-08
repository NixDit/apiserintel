<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class EmployeeSalesReportExport implements
FromCollection,
Responsable,
WithMapping,
WithHeadings,
WithTitle,
ShouldAutoSize,
WithDrawings,
WithStyles,
WithCustomStartCell,
WithCustomValueBinder
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;
    private $rowNumber = 0;

    public function __construct($datos)
    {
        $this->data = $datos;
    }
    public function startCell(): string
    {
        return 'A2';
    }
    // COLUMNAS A DESCARGAR
    public function map($row): array
    {
        $types = ['Prepago', 'Pagado', 'Postpago'];
        
        return [
            ++$this->rowNumber,
            "{$row->seller->name} {$row->seller->last_name} ",
            $row->costumer->clientInformation->business_name,
            number_format((float)$row->subtotal, 2, '.', ''),
            number_format((float)$row->total, 2, '.', ''),
            $types[ $row->type - 1 ],
            $row->folio,
            Carbon::parse($row->created_at)->format('d/m/Y - H:i:s')
        ];
    }
    // HEADINGS
    public function headings(): array
    {
        return [
            'No.',
            'Vendedor',
            'Cliente',
            'Subtotal $',
            'Total $',
            'Tipo',
            'Folio',
            'Fecha'
        ];
    }
    
    // TITULO DE LA PESTAÑA
    public function title(): string
    {
        return 'Reporte de ventas';
    }
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setPath(public_path('images/Logo.png'));
        $drawing->setHeight(30)->setWidth(100);
        $drawing->setCoordinates('H1');
        $drawing->setOffsetX(25);
        $drawing->setOffsetY(5);

        return $drawing;
    }
    // ESTILOS
    public function styles(Worksheet $sheet)
    {
        $sheet->getRowDimension('1')->setRowHeight(45);
        $styleArrayHead = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'ffffff',
                ]
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'ffffff'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];
        $styleArrayHeadings = [
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => 'ffffff'
                ]
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '4FCE5D',
                ]
            ],
        ];
        $styleArrayRows = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '00000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1:H1')->applyFromArray($styleArrayHead);
        $sheet->getStyle('A2:H2')->applyFromArray($styleArrayHeadings);
        $sheet->getStyle(
            'A2:'.
            $sheet->getHighestColumn() . 
            $sheet->getHighestRow()
        )->applyFromArray($styleArrayRows);
        // HORIZONTAL
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    }

    public function bindValue(Cell $cell, $value)
    {
        $cell->setValueExplicit($value, DataType::TYPE_STRING);
        return true;
    }

    public function collection()
    {
        return $this->data;
    }
}
