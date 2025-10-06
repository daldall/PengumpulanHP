<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuruExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
     * Mengambil data collection yang akan di-export.
     */
    public function collection()
    {
        return User::where('role', 'guru')->get();
    }

    /**
     * Memetakan data dari setiap baris collection.
     *
     * @param \App\Models\User $guru
     */
    public function map($guru): array
    {
        return [
            $guru->id,
            $guru->name,
            $guru->email,
            $guru->created_at->format('d/m/Y H:i'),
            $guru->updated_at->format('d/m/Y H:i'),
        ];
    }

    /**
     * Menentukan header untuk tabel Excel.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Guru',
            'Email',
            'Tanggal Dibuat',
            'Terakhir Diubah',
        ];
    }

    /**
     * Memberikan style pada sheet Excel.
     */
    public function styles(Worksheet $sheet)
    {
        // Total kolom sekarang adalah 5 (A sampai E)
        $lastColumn = 'E';

        // Style untuk header (baris pertama)
        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => '4F81BD']
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        $lastRow = $sheet->getHighestRow();

        // Style border untuk seluruh tabel
        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Alignment center untuk kolom ID dan tanggal
        $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("D2:E{$lastRow}")->getAlignment()->setHorizontal('center');

        return $sheet;
    }
}
