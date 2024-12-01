<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\CompanyReceivable;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class EmpresaSheetExport implements
    FromCollection,
    WithHeadings,
    WithTitle,
    WithColumnFormatting,
    ShouldAutoSize,
    WithEvents
{
    use RegistersEventListeners;

    

    protected $empresa;

    // Propiedad estática temporal para almacenar la empresa
    protected static $tempEmpresa;

    public function __construct(CompanyReceivable $empresa)
    {
        $this->empresa = $empresa;
        self::$tempEmpresa = $empresa; // Almacenar temporalmente
    }

    public function collection()
    {
        return $this->empresa->bills->map(function ($bill) {
            $expirationDate = \Carbon\Carbon::parse($bill->expiration_date);

            $today = \Carbon\Carbon::now();
            $daysRemaining = floor($expirationDate->diffInDays($today, false));

            return [
                'numero de orden' => $bill->order_number,
                'numero de factura' => $bill->bill_number,
                'Fecha Factura' => $bill->bill_date ? Date::dateTimeToExcel(Carbon::parse($bill->bill_date)) : null,
                'Fecha de entrada' => $bill->entry_date ? Date::dateTimeToExcel(Carbon::parse($bill->entry_date)) : null,
                'Fecha de expiración' => $bill->expiration_date ? Date::dateTimeToExcel(Carbon::parse($bill->expiration_date)) : null,
                'dias_vencidos_o_por_vencer' => $daysRemaining,
                'descripcion' => $bill->description,
                'total_a_pagar' => $bill->total_payment,
                'status' => $bill->status,
                'fecha_de_pago' => $bill->payment_day ? Date::dateTimeToExcel(Carbon::parse($bill->payment_day)) : null,
                'comentario' => $bill->comentary,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No. Orden',
            'No. Factura',
            'Fecha de Factura',
            'Fecha de Ingreso',
            'Fecha de Expiración',
            'Días Vencidos o por Vencer',
            'Descripción',
            'Total',
            'Status',
            'Fecha de Pago',
            'Comentario',
        ];
    }

    public function title(): string
    {
        return $this->empresa->name;
    }

    public function columnFormats(): array
    {
        return [
            //FECHAS
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'J' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            //MONTOS
            'H' => '"$"#,##0.00_-',


        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $empresa = $this->empresa; // Acceder a la empresa actual
    
                // Ajustar automáticamente el ancho de las columnas en esta hoja
                foreach (range('A', $sheet->getHighestColumn()) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
    
                // Combinar y dar formato a las primeras filas (encabezado)
                $sheet->mergeCells('A1:K1');
                $sheet->setCellValue('A1', 'Empresa S.A DE CV');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'name' => 'Arial',
                        'bold' => true,
                        'size' => 20,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
    
                $sheet->mergeCells('A2:K2');
                $sheet->setCellValue('A2', $empresa->name);
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'name' => 'Arial',
                        'bold' => true,
                        'size' => 18,
                        'color' => ['rgb' => 'FF0000'],
                        'underline' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);


                // 5. Agregar el logo de la empresa
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo de la empresa');
                $drawing->setPath(public_path('images/logo.png')); // Cambia esta ruta a la del logo
                $drawing->setHeight(64); // 2.26 cm = 64 pixeles aproximadamente
                $drawing->setWidth(71); // 2.51 cm = 71 pixeles aproximadamente
                $drawing->setCoordinates('C1');
                $drawing->setWorksheet($sheet);

                // Establecer autoSize en false solo para la columna G
                $sheet->getColumnDimension('G')->setAutoSize(false);
                $sheet->getColumnDimension('G')->setWidth(30); // Ancho específico para la columna G

                  // Establecer autoSize en false solo para la columna K
                  $sheet->getColumnDimension('K')->setAutoSize(false);
                  $sheet->getColumnDimension('K')->setWidth(30); // Ancho específico para la columna K 
    
                $sheet->mergeCells('A3:K3');
                $sheet->setCellValue('A3', 'Sucursal Villahermosa');
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => [
                        'name' => 'Arial',
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
    
                // Rellenar las filas 4 y 5 con vacío (como espacio)
                $sheet->setCellValue('A4', '');
                $sheet->mergeCells('A4:K4');
                $sheet->setCellValue('A5', '');
                $sheet->mergeCells('A5:K5');
    
                // Aplicar los encabezados en la fila 6 y los datos desde la fila 7
                $sheet->fromArray($this->headings(), null, 'A6');
                $sheet->fromArray($this->collection()->toArray(), null, 'A7');
    
                // Aplicar estilos a la fila de encabezado (fila 6)
                $sheet->getStyle('A6:K6')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['argb' => 'FFCCCCCC'], // Gris claro
                    ],
                ]);

                  //Centrar texto
                  $sheet->getStyle('A:Z')->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
    
                // Alternar colores de fondo en las filas para el efecto "striped"
                $highestRow = $sheet->getHighestRow();
                for ($row = 7; $row <= $highestRow; $row++) { // Comienza en la fila 7 para los datos
                    $color = ($row % 2 === 0) ? 'FFE0EAF1' : 'FFFFFFFF'; // Azul claro y blanco
                    $sheet->getStyle("A{$row}:K{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['argb' => $color],
                        ],
                    ]);
                }
    
                // Aplicar bordes a todas las celdas del rango de datos
                $cellRange = 'A6:K' . $highestRow;
                $sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
    
                // Establecer filtros en la fila de encabezado
                $sheet->setAutoFilter('A6:K6');
            },
        ];
    }
}


