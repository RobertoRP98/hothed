<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Bill;
use App\Models\Currency;
use App\Models\CompanyReceivable;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class ResumenTotalesExport implements 
    FromArray, WithTitle, WithColumnFormatting, ShouldAutoSize, WithEvents
{

    use RegistersEventListeners;

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
    $totalesGenerales[] = ['Privadas', 'Total Privadas Pendiente de Facturar', $totalPrivadasPendienteFacturar];
    $totalesGenerales[] = ['Privadas', 'Total Privadas Facturas Vencidas', $totalPrivadasVencidas];
    $totalesGenerales[] = ['Privadas', 'Total Privadas Facturas No Vencidas', $totalPrivadasNoVencidas];
    $totalesGenerales[] = ['Pemex', 'Total Pemex Pendiente de Facturar', $totalPublicasPendienteFacturar];
    $totalesGenerales[] = ['Pemex', 'Total Pemex Facturas Vencidas', $totalPublicasVencidas];
    $totalesGenerales[] = ['Pemex', 'Total Pemex Facturas No Vencidas', $totalPublicasNoVencidas];

    // SECCIÓN DERECHA: Totales por Empresa
    $totalesPorEmpresa = [
        ['Empresa', 'Pendiente de Cobrar','Pendiente de Entrada', 'Pendiente de Facturar', ]
    ];

    $empresas = CompanyReceivable::with('bills')->get();

    foreach ($empresas as $empresa) {
        //$totalGlobal = $empresa->bills->where('status', '!=', 'cancelado')->sum('total_payment');
        $totalPendienteCobrar = $empresa->bills->where('status', 'pendiente_cobrar')->sum('total_payment');
        $totalPendienteFacturar = $empresa->bills->where('status', 'pendiente_facturar')->sum('total_payment');
        $totalPendienteEntrada = $empresa->bills->where('status', 'pendiente_entrada')->sum('total_payment');

        //$totalPagado = $empresa->bills->where('status', 'pagado')->sum('total_payment');

        $totalesPorEmpresa[] = [
            $empresa->name,
            //$totalGlobal,
            $totalPendienteCobrar,
            $totalPendienteEntrada,
            $totalPendienteFacturar,
            //$totalPagado
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
        return 'Resumen General';
    }

    public function columnFormats(): array
    {
        return [
            'C' => '"$"#,##0.00_-',
            'F' => '"$"#,##0.00_-',
            'G' => '"$"#,##0.00_-',
            'H' => '"$"#,##0.00_-',

            //'H' => '"$"#,##0.00_-',
            //'I' => '"$"#,##0.00_-',
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        // AutoSize para todas las columnas
    foreach (range('A', strtoupper($event->sheet->getDelegate()->getHighestColumn())) as $col) {
        $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
    }

    // Formato de la primera fila (cabecera)
    $event->sheet->getStyle('A1:H1')->applyFromArray([
        'font' => [
            'name' => 'Arial',
            'bold' => true,
            'size'=> 15, // tamaño de la fuente de los encabezados
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color' => ['argb' => 'FFCCCCCC'],
        ],
    ]);

    //Centrar texto
    $event->sheet->getStyle('A:Z')->applyFromArray([
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
    ]);

    // Alternar colores de fondo en las filas
    $highestRow = $event->sheet->getDelegate()->getHighestRow();
    for ($row = 2; $row <= $highestRow; $row++) { // Comienza en la segunda fila para no aplicar en la cabecera
        $color = ($row % 2 === 0) ? 'FFE0EAF1' : 'FFFFFFFF'; // Azul claro y blanco
        $event->sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => $color],
            ],
            'font' => [
               'name' => 'Arial',
                'size' => 15, // tamaño de fuente del contenido
            ],
        ]);
    }

    // Borde para todas las celdas en el rango
    $cellRange = 'A1:' . strtoupper($event->sheet->getDelegate()->getHighestColumn()) . $highestRow;
    $event->sheet->getStyle($cellRange)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ]);

        // Aplicar filtro a todas las columnas del rango
        $event->sheet->setAutoFilter($cellRange);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [self::class, 'afterSheet'],

            
        ];
    }
}