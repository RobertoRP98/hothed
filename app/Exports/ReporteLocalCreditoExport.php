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
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ReporteLocalCreditoExport implements
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

        $orders = PurchaseOrder::with('requisition', 'supplier')
            //->whereBetween('date_start', [$startDate, $endDate])
            ->where('type_op', 'Local')
            ->whereIn('payment_type', ['CREDITO'])
            ->get()
            ->map(function ($order) {
                // Calcular días restantes
                $daysRemaining = floor(Carbon::parse($order->requisition->production_date)->diffInDays(now(), false));
                $daysRemaining = ($daysRemaining === null || $daysRemaining === '') ? 0 : $daysRemaining;
                
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
                    'Requi Date' => $order->requisition->request_date ? Carbon::parse($order->requisition->request_date)->format('d-m-Y') : 'SIN FECHA',
                    'Order ID' => "VH-". $order->id ."-". $order->created_at->format('y'),
                    'Fecha creación' => $order->date_start ? Carbon::parse($order->date_start)->format('d-m-Y') : 'SIN FECHA',
                    'Supplier' => $order->supplier->name, // Asumiendo que hay una relación con el modelo Supplier
                    'Proyect' => $order->requisition->notes_client,
                    'Dep' => $order->requisition->user->area,
                    'Quotation' => $order->quotation,
                    'Total' => $order->total,
                    'Divisa'=> $order->currency,
                    'Prioridad' => $priority,
                    'Días Restantes' => (string) (($daysRemaining === null || $daysRemaining === '') ? 0 : $daysRemaining),
                    'Status' => match ($order->po_status){
                        'PENDIENTE DE PAGO' => 'PENDIENTE DE COMPRA/SERVICIO',
                        'PENDIENTE DE PAGO (SERVICIO CONCLUIDO)' => 'COMPRA/SERVICIO CONCLUIDO SIN PAGO',
                        default=> $order->po_status
                    },
                    'Payment type' => $order->payment_type,
                    'Factura' => $order->bill_name,
                    'Notes' => $order->requisition->notes_resp,

                  //  'Required Date' => $order->requisition->required_date ? Carbon::parse($order->requisition->required_date)->format('d-m-Y') : 'SIN FECHA',
                    //'Aut 4' => $order->authorization_4, // Asegúrate del campo correcto
                ];
            });

        return $orders; // <-- Asegúrate de retornar la colección
    }


    public function headings(): array
    {
        return [
            'REQUISICION',
            'FECHA REQUISICIÓN',
            'ORDEN',
            'FECHA ORDEN',
            'PROVEEDOR',
            'PROYECTO',
            'DEPARTAMENTO',
            'COTIZACIÓN',
            'TOTAL',
            'DIVISA',
            'PRIORIDAD',
            'DIAS RESTANTES',
            'STATUS',
            'TIPO DE PAGO',
            'FACTURA',
            'COMENTARIO'
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
        return 'CREDITO';
    }

    public function columnFormats(): array
    {
        return [
            //MONTOS
            'I' => '"$"#,##0.00_-',

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
                $sheet->setAutoFilter('A1:P1');

                // Aplicar estilos a la fila de encabezado (fila 1)
                $sheet->getStyle('A1:P1')->applyFromArray([
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
                    $sheet->getStyle("A{$row}:P{$row}")->applyFromArray([
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
