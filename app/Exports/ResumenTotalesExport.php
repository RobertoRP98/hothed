<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Bill;
use App\Models\Currency;
use App\Models\CompanyReceivable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ResumenTotalesExport implements 
FromArray, WithTitle, WithColumnFormatting, ShouldAutoSize
{

    use RegistersEventListeners;

    public static function afterSheet(\Maatwebsite\Excel\Events\AfterSheet $event)
    {
        // Ajustar automáticamente el ancho de las columnas en esta hoja
        foreach (range('A', $event->sheet->getDelegate()->getHighestColumn()) as $col) {
            $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
        }
    }


    public function array(): array
    {
        // INICIAN PRIMEOS 6 CALCULOS
        $dollarRate = Currency::where('currency', 'USD')->latest()->value('rate');

        // Calcular totales para empresas privadas
        $totalPrivadasPendienteFacturar = Bill::whereHas('companyreceivable', function ($query) {
            $query->where('type', 'Privada');
        })->where('status', 'pendiente_facturar')->sum('total_payment');

        $totalPrivadasVencidas = Bill::whereHas('companyreceivable', function ($query) {
            $query->where('type', 'Privada');
        })->where('status', 'pendiente_cobrar')->get()->filter(function ($bill) {
            $expirationDate = Carbon::parse($bill->expiration_date);
            $today = Carbon::now();
            return $expirationDate->diffInDays($today, false) >= 0;
        })->sum('total_payment');

        $totalPrivadasNoVencidas = Bill::whereHas('companyreceivable', function ($query) {
            $query->where('type', 'Privada');
        })->where('status', 'pendiente_cobrar')->get()->filter(function ($bill) {
            $expirationDate = Carbon::parse($bill->expiration_date);
            $today = Carbon::now();
            return $expirationDate->diffInDays($today, false) < 0;
        })->sum('total_payment');

        // Calcular totales para empresas públicas (Pemex)
        $totalPublicasPendienteFacturar = Bill::whereHas('companyreceivable', function ($query) {
            $query->where('type', 'Pemex');
        })->where('status', 'pendiente_facturar')->get()->map(function ($bill) use ($dollarRate) {
            return $bill->companyreceivable->currency == 'MXN' ? $bill->total_payment / $dollarRate : $bill->total_payment;
        })->sum();

        $totalPublicasVencidas = Bill::whereHas('companyreceivable', function ($query) {
            $query->where('type', 'Pemex');
        })->where('status', 'pendiente_cobrar')->get()->map(function ($bill) use ($dollarRate) {
            $expirationDate = Carbon::parse($bill->expiration_date);
            $today = Carbon::now();
            return $expirationDate->diffInDays($today, false) >= 0 ? ($bill->companyreceivable->currency == 'MXN' ? $bill->total_payment / $dollarRate : $bill->total_payment) : 0;
        })->sum();

        $totalPublicasNoVencidas = Bill::whereHas('companyreceivable', function ($query) {
            $query->where('type', 'Pemex');
        })->where('status', 'pendiente_cobrar')->get()->map(function ($bill) use ($dollarRate) {
            $expirationDate = Carbon::parse($bill->expiration_date);
            $today = Carbon::now();
            return $expirationDate->diffInDays($today, false) < 0 ? ($bill->companyreceivable->currency == 'MXN' ? $bill->total_payment / $dollarRate : $bill->total_payment) : 0;
        })->sum();
        // TERMINAN PRIMEOS 6 CALCULOS




        //INICIAN TOTALES POR EMPRESA
        $empresas = CompanyReceivable::with('bills')->get();

                // Generar los totales por cada empresa
    foreach ($empresas as $empresa) {
        $totalGlobal = $empresa->bills->where('status', '!=', 'cancelado')->sum('total_payment');
        $totalPendienteCobrar = $empresa->bills->where('status', 'pendiente_cobrar')->sum('total_payment');
        $totalPendienteFacturar = $empresa->bills->where('status', 'pendiente_facturar')->sum('total_payment');
        $totalPagado = $empresa->bills->where('status', 'pagado')->sum('total_payment');
    
        $totals[] = [$empresa->name, $totalGlobal, $totalPendienteCobrar, $totalPendienteFacturar, $totalPagado];
    }

        //TERMINAN TOTALES POR EMPRESA

        $totals = [
            ['Tipo de Empresa', 'Estado', 'Gran Total en USD', '', 'Empresa', 'Total Global', 'Pendiente de Cobrar', 'Pendiente de Facturar', 'Pagado al dia de hoy'],
        ];
        
        // Lista de empresas agrupadas por tipo de empresa
        $empresasPorTipo = [
            'Privada' => [
                ['Gran Total Pendiente de Facturar', $totalPrivadasPendienteFacturar, isset($empresas[0]) ? $empresas[0] : null],
                ['Gran Total Facturas Vencidas', $totalPrivadasVencidas, isset($empresas[1]) ? $empresas[1] : null],
                ['Gran Total Facturas No Vencidas', $totalPrivadasNoVencidas, isset($empresas[2]) ? $empresas[2] : null],
            ],
            'Pemex' => [
                ['Gran Total Pendiente de Facturar', $totalPublicasPendienteFacturar, isset($empresas[3]) ? $empresas[3] : null],
                ['Gran Total Facturas Vencidas', $totalPublicasVencidas, isset($empresas[4]) ? $empresas[4] : null],
                ['Gran Total Facturas No Vencidas', $totalPublicasNoVencidas, isset($empresas[5]) ? $empresas[5] : null],
            ],
        ];
        
        foreach ($empresasPorTipo as $tipoEmpresa => $estados) {
            foreach ($estados as $estado) {
                $estadoNombre = $estado[0];
                $totalUSD = $estado[1];
                $empresa = $estado[2];
        
                if ($empresa) {
                    $totalGlobal = $empresa->bills->where('status', '!=', 'cancelado')->sum('total_payment');
                    $totalPendienteCobrar = $empresa->bills->where('status', 'pendiente_cobrar')->sum('total_payment');
                    $totalPendienteFacturar = $empresa->bills->where('status', 'pendiente_facturar')->sum('total_payment');
                    $totalPagado = $empresa->bills->where('status', 'pagado')->sum('total_payment');
        
                    $totals[] = [
                        $tipoEmpresa,
                        $estadoNombre,
                        $totalUSD,
                        '', // Columna vacía para separar
                        $empresa->name,
                        $totalGlobal,
                        $totalPendienteCobrar,
                        $totalPendienteFacturar,
                        $totalPagado,
                    ];
                } else {
                    $totals[] = [
                        $tipoEmpresa,
                        $estadoNombre,
                        $totalUSD,
                        '', // Columna vacía para separar
                        '', '', '', '', '', // Espacios vacíos ya que no hay empresa para esta fila
                    ];
                }
            }
        }
        
        return $totals;
    }

    public function title(): string
    {
        return 'Resumen Global';
    }

    public function columnFormats(): array
    {
        return[
            'C' => '"$"#,##0.00_-',
            'F' => '"$"#,##0.00_-',
            'G' => '"$"#,##0.00_-',
            'H' => '"$"#,##0.00_-',
            'I' => '"$"#,##0.00_-',
        ];
    }
}
