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
    $dollarRate = Currency::where('currency', 'USD')->latest()->value('rate');

    // SECCIÓN IZQUIERDA: Totales Generales por Tipo de Empresa
    $totalesGenerales = [
        ['Tipo de Empresa', 'Estado', 'Gran Total en USD']
    ];

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

    // Agregar los totales generales por tipo de empresa al array
    $totalesGenerales[] = ['Privada', 'Gran Total Pendiente de Facturar', $totalPrivadasPendienteFacturar];
    $totalesGenerales[] = ['Privada', 'Gran Total Facturas Vencidas', $totalPrivadasVencidas];
    $totalesGenerales[] = ['Privada', 'Gran Total Facturas No Vencidas', $totalPrivadasNoVencidas];
    $totalesGenerales[] = ['Pemex', 'Gran Total Pendiente de Facturar', $totalPublicasPendienteFacturar];
    $totalesGenerales[] = ['Pemex', 'Gran Total Facturas Vencidas', $totalPublicasVencidas];
    $totalesGenerales[] = ['Pemex', 'Gran Total Facturas No Vencidas', $totalPublicasNoVencidas];

    // SECCIÓN DERECHA: Totales por Empresa
    $totalesPorEmpresa = [
        ['Empresa', 'Total Global', 'Pendiente de Cobrar', 'Pendiente de Facturar', 'Pagado al día de hoy']
    ];

    $empresas = CompanyReceivable::with('bills')->get();

    foreach ($empresas as $empresa) {
        $totalGlobal = $empresa->bills->where('status', '!=', 'cancelado')->sum('total_payment');
        $totalPendienteCobrar = $empresa->bills->where('status', 'pendiente_cobrar')->sum('total_payment');
        $totalPendienteFacturar = $empresa->bills->where('status', 'pendiente_facturar')->sum('total_payment');
        $totalPagado = $empresa->bills->where('status', 'pagado')->sum('total_payment');

        $totalesPorEmpresa[] = [
            $empresa->name,
            $totalGlobal,
            $totalPendienteCobrar,
            $totalPendienteFacturar,
            $totalPagado
        ];
    }

    // COMBINAR AMBAS SECCIONES LADO A LADO
    $maxRows = max(count($totalesGenerales), count($totalesPorEmpresa));
    $finalArray = [];

    for ($i = 0; $i < $maxRows; $i++) {
        $leftSection = $totalesGenerales[$i] ?? ['', '', ''];
        $rightSection = $totalesPorEmpresa[$i] ?? ['', '', '', '', ''];
        $finalArray[] = array_merge($leftSection, [''], $rightSection);
    }

    return $finalArray;
}
    public function title(): string
    {
        return 'Resumen Global';
    }

    public function columnFormats(): array
    {
        return [
            'C' => '"$"#,##0.00_-',
            'F' => '"$"#,##0.00_-',
            'G' => '"$"#,##0.00_-',
            'H' => '"$"#,##0.00_-',
            'I' => '"$"#,##0.00_-',
        ];
    }
}
