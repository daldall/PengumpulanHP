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

class SiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
     * Mengambil data collection yang akan di-export.
     * Logika query utama diletakkan di sini.
     */
    public function collection()
    {
        $today = Carbon::today('Asia/Jakarta');

        return User::where('role', 'siswa')
            ->with(['pengumpulan' => function($query) use ($today) {
                $query->whereDate('waktu_input', $today->toDateString());
            }])
            ->get();
    }

    /**
     * Memetakan data dari setiap baris collection.
     * Logika untuk setiap baris diletakkan di sini.
     *
     * @param \App\Models\User $siswa
     */
    public function map($siswa): array
    {
        // Ambil data pengumpulan dari relasi yang sudah di-load
        $kumpul = $siswa->pengumpulan->where('status', 'dikumpulkan')->first();
        $ambil = $siswa->pengumpulan->where('status', 'diambil')->first();

        // Menentukan status akhir
        $statusAkhir = 'Belum Kumpul';
        if ($kumpul && !$ambil) {
            $statusAkhir = 'Belum Ambil';
        } elseif ($kumpul && $ambil) {
            $statusAkhir = 'Selesai';
        }

        return [
            $siswa->nis,
            $siswa->name,
            $siswa->kelas,
            $kumpul ? $kumpul->waktu_input->format('H:i:s') : '-',
            $kumpul ? ucfirst($kumpul->metode) : '-',
            $ambil ? $ambil->waktu_input->format('H:i:s') : '-',
            $ambil ? ucfirst($ambil->metode) : '-',
            $statusAkhir,
        ];
    }

    /**
     * Menentukan header untuk tabel Excel.
     */
    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Jam Kumpul',
            'Metode Kumpul',
            'Jam Ambil',
            'Metode Ambil',
            'Status Akhir',
        ];
    }

    /**
     * Memberikan style pada sheet Excel.
     */
    public function styles(Worksheet $sheet)
    {
        // Total kolom sekarang adalah 8 (A sampai H)
        $lastColumn = 'H';

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

        // Alignment center untuk kolom C sampai H
        $sheet->getStyle("C2:{$lastColumn}{$lastRow}")->getAlignment()->setHorizontal('center');

        return $sheet;
    }
}
