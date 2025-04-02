<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ReporteLocalDebitoExport implements
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
    public function collection()
    {
        //$startDate = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d'); // Lunes pasado
        //$endDate = Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d'); // Domingo pasado

        $orders = PurchaseOrder::with('requisition', 'supplier')
            //->whereBetween('date_start', [$startDate, $endDate])
            ->where('type_op', 'Local')
            ->whereIn('payment_type',['DEBITO','CAJA CHICA','TRANSFERENCIA'])
            ->get()
            ->map(function ($order) {
                // Calcular días restantes
                //$daysRemaining = floor(now()->diffInDays(Carbon::parse($order->requisition->production_date), false));
                $daysRemaining = floor(Carbon::parse($order->requisition->production_date)->diffInDays(now(), false));



                // Determinar prioridad
                if ($daysRemaining >= -15) {
                    $priority = 'ALTA';
                } elseif ($daysRemaining >= -30) {
                    $priority = 'MEDIA';
                } else {
                    $priority = 'BAJA';
                }

                return [
                    'Requisition ID' => $order->requisition_id,
                    'Order ID' => $order->id,
                    'Supplier' => $order->supplier->name, // Asumiendo que hay una relación con el modelo Supplier
                    'Required Date' => $order->requisition->required_date,
                    'Quotation' => $order->quotation,
                    'Fecha creación' => $order->date_start ? Carbon::parse($order->date_start)->format('d-m-Y') : 'SIN FECHA',
                    'Total' => $order->total . '' . $order->currency,
                    'Dep' => $order->requisition->user->area,
                    'Aut 4' => $order->authorization_4, // Asegúrate del campo correcto
                    'Status' => $order->po_status,
                    'Factura' => $order->bill_name,
                    'Prioridad' => $priority,
                    'Días Restantes' => $daysRemaining,
                    'Notes' => $order->requisition->notes_resp,
                ];
            });

        return $orders; // <-- Asegúrate de retornar la colección
    }

    public function headings(): array
    {
        return ['REQUISICION', 
                'ORDEN',
                'PROVEEDOR',
                'FECHA REQUERIDA',
                'COTIZACIÓN',
                'FECHA CREACIÓN OC',
                'TOTAL',
                'DEPARTAMENTO',
                'AUTORIZACIÓN',
                'STATUS',
                'FACTURA',
                'PRIORIDAD',
                'DIAS RESTANTES',
                'COMENTARIOS',            
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
        return 'CONTADO';
    }

    public function columnFormats(): array
    {
        return [
            //MONTOS
            'G' => '"$"#,##0.00_-',

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
                $sheet->setAutoFilter('A1:N1');

                // Aplicar estilos a la fila de encabezado (fila 1)
                $sheet->getStyle('A1:N1')->applyFromArray([
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
                    $sheet->getStyle("A{$row}:N{$row}")->applyFromArray([
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
