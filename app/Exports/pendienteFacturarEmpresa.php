<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Bill;
use App\Models\CompanyReceivable;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class pendienteFacturarEmpresa implements
 FromArray,
 WithHeadings,
 WithTitle,
WithColumnFormatting,
ShouldAutoSize,
WithEvents
{

    use RegistersEventListeners;

    protected $empresa;

    //propiedad estetica temporal para almacenar la empresa
    protected static $tempEmpresa;

    public function __construct(CompanyReceivable $empresa)
    {
     $this->empresa = $empresa;
    // self::$tempEmpresa = $empresa; //almacenar temporalmente   
    }
   
    public function array(): array
    {
        // Obtener las facturas con el estado "pendiente_facturar" para esta empresa
        $pendienteFacturar = Bill::where('companyreceivable_id', $this->empresa->id) 
        ->where('status', 'pendiente_facturar') // Solo facturas pendientes
        ->get();

        if ($pendienteFacturar->isEmpty()) {
            return [['Sin datos disponibles para esta empresa.']];
        }

        return $pendienteFacturar->map(function ($bill) {
            $expirationDate = Carbon::parse($bill->expiration_date);
            $today = Carbon::now();
           // $daysRemaining = $expirationDate ? $expirationDate->diffInDays($today, false) : 'SIN FECHA';

            return [
                'bill_number' => $bill->bill_number,

                'start_operation' => $bill->start_operation 
                ? Date::dateTimeToExcel(Carbon::parse($bill->start_operation)) 
                : 'SIN FECHA ASIGNADA',

                'end_operation' => $bill->end_operation 
                ? Date::dateTimeToExcel(Carbon::parse($bill->end_operation)) 
                : 'SIN FECHA ASIGNADA',

                //'days_remaining' => $daysRemaining,
                'description' => $bill->description,

                'total_payment' => $bill->total_payment,

                'comentary' => $bill->comentary,
                
                'status' => $bill->status,
            ];
        })
        ->toArray();

        return $pendienteFacturar;
    }

    public function headings(): array
    {
        return[
            'Número de Factura', 
             'Fecha de inicio de trabajo',
             'Fecha de fin de trabajo',
             'Descripción',
            //'Dias vencidos/ Por Vencer',
            'Total a Pagar',
            'Comentario',
            'Status',

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
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            //MONTOS
            'E' => '"$"#,##0.00_-',


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
                
                
                // Establecer autoSize en false
                
                $sheet->getColumnDimension('B')->setAutoSize(false);
                $sheet->getColumnDimension('B')->setWidth(25); 

                $sheet->getColumnDimension('C')->setAutoSize(false);
                $sheet->getColumnDimension('C')->setWidth(25); 
                
                $sheet->getColumnDimension('D')->setAutoSize(false);
                $sheet->getColumnDimension('D')->setWidth(30); 
                
                //Filtros
                $sheet->setAutoFilter('A1:G1');

                //

                 // Aplicar estilos a la fila de encabezado (fila 1)
                 $sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['argb' => 'FFCCCCCC'], // Gris claro
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                //

                // Alternar colores de fondo en las filas para el efecto "striped"
                $highestRow = $sheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; $row++) { // Comienza en la fila 7 para los datos
                    $color = ($row % 2 === 0) ? 'FFE0EAF1' : 'FFFFFFFF'; // Azul claro y blanco
                    $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['argb' => $color],
                        ],
                    ]);
                }

                //Centrar texto
                $sheet->getStyle('A:Z')->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);

                //Quita el wrap a la columna de descripcion o comentario
                $sheet->getStyle('D')->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_GENERAL, // Alineación predeterminada horizontal
                        'vertical' => Alignment::VERTICAL_TOP,         // Alineación predeterminada vertical
                        'wrapText' => false,                           // Desactivar el ajuste de texto
                    ],
                ]);


            }
        ];
}
}