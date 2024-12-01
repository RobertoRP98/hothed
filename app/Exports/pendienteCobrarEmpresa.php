<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Bill;
use App\Models\CompanyReceivable;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class pendienteCobrarEmpresa implements
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
        $pendienteCobrar = Bill::where('companyreceivable_id', $this->empresa->id) 
        ->where('status', 'pendiente_cobrar') // Solo facturas pendientes
        ->get();

        if ($pendienteCobrar->isEmpty()) {
            return [['Sin datos disponibles para esta empresa.']];
        }

        return $pendienteCobrar->map(function ($bill) {
            $expirationDate = Carbon::parse($bill->expiration_date);
            $today = Carbon::now();
           $daysRemaining = floor($expirationDate ? $expirationDate->diffInDays($today, false) : 'SIN FECHA');

            return [
                'bill_number' => $bill->bill_number,
                'bill_date' => $bill->bill_date ? Carbon::parse($bill->bill_date)->format('d-m-Y') : 'SIN FECHA',
                'expiration_date' => $bill->expiration_date ? Carbon::parse($bill->expiration_date)->format('d-m-Y') : 'SIN FECHA',
                'days_remaining' => $daysRemaining,
                'total_payment' => $bill->total_payment,
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
            'Fecha de Factura',
            'Fecha de Expiración',
            'Dias vencidos/ Por Vencer',
            'Total a Pagar',
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
                $empresaId = $this->empresa; // Acceder a la empresa actual
    
                // Ajustar automáticamente el ancho de las columnas en esta hoja
                foreach (range('A', $sheet->getHighestColumn()) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                //Filtros
                $sheet->setAutoFilter('A1:F1');

                
                // Aplicar estilos a la fila de encabezado (fila 1)
                $sheet->getStyle('A1:F1')->applyFromArray([
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
                    $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
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

                
                
            }
        ];
}
}