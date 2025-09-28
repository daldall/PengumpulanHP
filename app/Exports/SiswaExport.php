<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Pengumpulan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $laporan;

    public function __construct()
    {
        $today = Carbon::today('Asia/Jakarta');

        $data = User::where('role', 'siswa')
            ->with(['pengumpulan' => function($query) use ($today) {
                $query->whereDate('waktu_input', $today->toDateString());
            }])
            ->get();

        $laporan = [];
        foreach ($data as $siswa) {
            $kumpul = $siswa->pengumpulan->where('status', 'dikumpulkan')->first();
            $ambil = $siswa->pengumpulan->where('status', 'diambil')->first();

            $statusAkhir = 'Belum Kumpul';
            if ($kumpul && $ambil) {
                $statusAkhir = 'Selesai';
            } elseif ($kumpul && !$ambil) {
                $statusAkhir = 'Belum Ambil';
            }

            $laporan[] = [
                'nis' => $siswa->nis,
                'nama' => $siswa->name,
                'kelas' => $siswa->kelas,
                'jam_kumpul' => $kumpul ? $kumpul->waktu_input->format('H:i:s') : '-',
                'metode_kumpul' => $kumpul ? ucfirst($kumpul->metode) : '-',
                'jam_ambil' => $ambil ? $ambil->waktu_input->format('H:i:s') : '-',
                'metode_ambil' => $ambil ? ucfirst($ambil->metode) : '-',
                'status_akhir' => $statusAkhir,
            ];
        }

        $this->laporan = $laporan;
    }

    public function collection()
    {
        return collect($this->laporan);
    }

    public function map($data): array
    {
        return [
            $data['nis'],
            $data['nama'],
            $data['kelas'],
            $data['jam_kumpul'],
            $data['metode_kumpul'],
            $data['jam_ambil'],
            $data['metode_ambil'],
            $data['status_akhir'],
        ];
    }

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

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->applyFromArray([
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
        $sheet->getStyle("A1:G{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        $sheet->getStyle("C2:G{$lastRow}")->getAlignment()->setHorizontal('center');
    }
}
