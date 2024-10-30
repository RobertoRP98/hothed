<?php

namespace App\Exports;

use App\Models\Bill;
use App\Models\Currency;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class ResumenTotalesExport implements FromArray, WithTitle
{
    public function array(): array
    {
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

        // Armar el array con los resultados
        $totals = [
            ['Tipo de Empresa', 'Estado', 'Total en USD'],
            ['Privada', 'Pendiente de Facturar', $totalPrivadasPendienteFacturar],
            ['Privada', 'Vencidas', $totalPrivadasVencidas],
            ['Privada', 'No Vencidas', $totalPrivadasNoVencidas],
            ['Pemex', 'Pendiente de Facturar', $totalPublicasPendienteFacturar],
            ['Pemex', 'Vencidas', $totalPublicasVencidas],
            ['Pemex', 'No Vencidas', $totalPublicasNoVencidas],
        ];

        return $totals;
    }

    public function title(): string
    {
        return 'Resumen Global';
    }
}
