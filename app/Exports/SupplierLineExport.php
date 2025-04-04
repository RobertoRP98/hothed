<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SupplierLineExport implements 
FromCollection,
WithHeadings,
WithTitle,
WithColumnFormatting,
ShouldAutoSize,
WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $line;

    public function __construct($line)
    {
        $this ->line = $line;
    }


    public function collection()
    {
        return Supplier::where('product_type', $this->line)
        ->get(['name','critic', 'status'])
        ->map(function ($supplier){
            return [
                'name' => $supplier->name,
                'critic' => $supplier->critic == 1 ? 'SI' : 'NO',
                'status' => $supplier->status
            ];
        });
    }

    public function headings(): array
    {
        return ['NOMBRE', 
                'CRITICO',
                'STATUS',
                            
    ];
    }

    // public function map($row): array
    // {
    //     return [
    //        //Aui si no se si aplique, ojito chat
    //     ];
    // }

    public function title(): string
    {
        return $this->line ?: 'Sin Linea';
    }

    public function columnFormats(): array
    {
        return [
           

        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Ajustar automáticamente el ancho de las columnas en esta hoja
                foreach (range('A', $sheet->getHighestColumn()) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
                //FILTROS
                $sheet->setAutoFilter('A1:C1');

                // Aplicar estilos a la fila de encabezado (fila 1)
                $sheet->getStyle('A1:C1')->applyFromArray([
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
                    $sheet->getStyle("A{$row}:C{$row}")->applyFromArray([
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
