<?php

namespace App\Exports;

use App\Models\Toolwarehouse;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;


class ToolwarehouseExport implements
    FromArray,
    WithHeadings,
    WithTitle,
    ShouldAutoSize,
    WithEvents

{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function array(): array
    {
        return Toolwarehouse::query()
            ->with(['family', 'subgroup', 'toolstatus', 'base']) // Relaciona las tablas foráneas
            ->select([
                'id',
                'family_id',
                'subgroup_id',
                'description',
                'serienum',
                'extdia',
                'guidia',
                'insdia',
                'fishingneck',
                'conpin',
                'conbox',
                'opera',
                'length',
                'necklength',
                'lastinsp',
                'datelastinsp',
                'outfolio',
                'departuredate',
                'toolstatus_id',
                'comentary',
                'intloca',
                'QR',
                'base_id',
            ])->get()
            ->map(function ($toolwarehouse) {
                return [
                    'id' => $toolwarehouse->id,
                    'family' => $toolwarehouse->family ? $toolwarehouse->family->name : 'FAMILIA NO ENCONTRADA',
                    'subgroup' => $toolwarehouse->subgroup ? $toolwarehouse->subgroup->name : 'SUBGRUPO NO ENCONTRADO',
                    'description' => $toolwarehouse->description,
                    'serienum' => $toolwarehouse->serienum,
                    'extdia' => $toolwarehouse->extdia,
                    'guidia' => $toolwarehouse->guidia,
                    'insdia' => $toolwarehouse->insdia,
                    'fishingneck' => $toolwarehouse->fishingneck,
                    'conpin' => $toolwarehouse->conpin,
                    'conbox' => $toolwarehouse->conbox,
                    'opera' => $toolwarehouse->opera,
                    'length' => $toolwarehouse->length,
                    'necklength' => $toolwarehouse->necklength,
                    'lastinsp' => $toolwarehouse->lastinsp,
                    'datelastinsp' => $toolwarehouse->datelastinsp,
                    'outfolio' => $toolwarehouse->outfolio,
                    'departuredate' => $toolwarehouse->departuredate,
                    'toolstatus' => $toolwarehouse->toolstatus ? $toolwarehouse->toolstatus->status : 'STATUS NO DEFINIDO',
                    'comentary' => $toolwarehouse->comentary,
                    'intloca' => $toolwarehouse->intloca,
                    'QR' => $toolwarehouse->QR,
                    'base'=> $toolwarehouse->toolstatus ? $toolwarehouse->base->name : 'EMPRESA NO ENCONTRADA',
                ];
            })
            ->toArray();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Familia',
            'Subgrupo',
            'Descripción',
            'Numero de Serie',
            'Diametro Externo',
            'Diametro de Guia',
            'Diametro de Inserción',
            'Cuello de Pesca',
            'Conexión Pin',
            'Conexión Box',
            'Operador',
            'Largo',
            'Largo de Cuello',
            'Ultima Inspección',
            'Fecha Ultima Inspección',
            'Folio de Salida',
            'Fecha de Salida',
            'Status de Herramienta',
            'Comentario',
            'Localización Interna',
            'QR',
            'EMPRESA',

        ];
    }

    public function title(): string
    {
        return 'HERRAMIENTAS HOTHED';
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



                // Establecer autoSize en false solo para la columna G
                $sheet->getColumnDimension('D')->setAutoSize(false);
                $sheet->getColumnDimension('D')->setWidth(30); // Ancho específico para la columna G



                // Aplicar los encabezados en la fila 6 y los datos desde la fila 7
                $sheet->fromArray($this->headings(), null, 'A1');
                //$sheet->fromArray($this->collection()->toArray(), null, 'A7');

                // Aplicar estilos a la fila de encabezado (fila 6)
                $sheet->getStyle('A1:W1')->applyFromArray([
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
                for ($row = 2; $row <= $highestRow; $row++) { // Comienza en la fila 7 para los datos
                    $color = ($row % 2 === 0) ? 'FFE0EAF1' : 'FFFFFFFF'; // Azul claro y blanco
                    $sheet->getStyle("A{$row}:W{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['argb' => $color],
                        ],
                    ]);
                };

                // Aplicar bordes a todas las celdas del rango de datos
                $cellRange = 'A1:W' . $highestRow;
                $sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Establecer filtros en la fila de encabezado
                $sheet->setAutoFilter('A1:W1');
            },
        ];
    }
}
