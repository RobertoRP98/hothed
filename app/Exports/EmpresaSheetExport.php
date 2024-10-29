<?php

namespace App\Exports;

use App\Models\CompanyReceivable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class EmpresaSheetExport implements FromCollection, WithHeadings, WithTitle
{
    
    protected $empresa;

    public function __construct(CompanyReceivable $empresa)
    {
        $this->empresa = $empresa;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->empresa->bills->map(function ($bill) {
            $expirationDate = \Carbon\Carbon::parse($bill->expiration_date);
            $today = \Carbon\Carbon::now();
            $daysRemaining = $expirationDate->diffInDays($today, false);

            return [
                'numero de orden' => $bill->order_number,
                'numero de factura' => $bill->bill_number,
                'fecha de factura' => optional($bill->bill_date)->format('d/m/Y'),
                'fecha de entrada' => optional($bill->entry_date)->format('d/m/Y'),
                'fecha de expiracion' => optional($expirationDate)->format('d/m/Y'),
                'dias_vencidos_o_por_vencer' => $daysRemaining,
                'total_a_pagar' => $bill->total_payment,
                'status' => $bill->status,
                'fecha_de_pago' => optional($bill->payment_day)->format('d/m/Y'),
                'comentario' => $bill->comentary,
                'fecha_creacion_factura' => optional($bill->created_at)->format('d/m/Y'),
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
            'Total',
            'Status',
            'Fecha de Pago',
            'Comentario',
            'Fecha de Creación de Factura',
        ];
    }

    public function title(): string
    {
        return $this->empresa->name;
    }

}
