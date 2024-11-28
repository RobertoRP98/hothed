<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Bill;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ResumenSemanal implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Calcula la semana anterior
        $hoy = Carbon::now(); // Fecha actual
        $lunesAnterior = $hoy->copy()->previous('monday')->subDays(7); // Lunes de la semana anterior
        $domingoAnterior = $lunesAnterior->copy()->addDays(6); // Domingo de la semana anterior

        // Filtra y agrupa los datos
        $resultados = Bill::select(
            'companyreceivable_id',
            DB::raw("SUM(CASE WHEN status = 'pendiente_cobrar' THEN total_payment ELSE 0 END) AS total_pendiente_cobrar"),
            DB::raw("SUM(CASE WHEN status = 'pagado' THEN total_payment ELSE 0 END) AS total_pagado")
        )
        ->where(function ($query) use ($lunesAnterior, $domingoAnterior) {
            $query->whereBetween('bill_date', [$lunesAnterior, $domingoAnterior]) // Para pendiente_cobrar
                  ->orWhereBetween('payment_day', [$lunesAnterior, $domingoAnterior]); // Para pagado
        })
        ->groupBy('companyreceivable_id')
        ->get();

        return $resultados;
    
    }

    public function headings(): array
    {
        return ['Empresa', 'Total Pendiente Cobrar', 'Total Pagado'];
    }

    public function map($row): array
    {
        return [
            $row->companyReceivable->name, // Nombre de la empresa usando la relación
            $row->total_pendiente_cobrar,
            $row->total_pagado,
        ];
    }
}
