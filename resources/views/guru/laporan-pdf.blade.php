<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengumpulan HP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-size: 10px;
        }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-danger { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PENGUMPULAN HP</h2>
        <p><strong>Tanggal:</strong> {{ $date->format('d F Y') }}</p>
        <p><strong>Dicetak pada:</strong> {{ now()->format('d F Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th class="text-center">Jam Kumpul</th>
                <th class="text-center">Metode Kumpul</th>
                <th class="text-center">Jam Ambil</th>
                <th class="text-center">Metode Ambil</th>
                <th class="text-center">Status Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $data)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $data['nis'] }}</td>
                <td>{{ $data['nama'] }}</td>
                <td>{{ $data['kelas'] }}</td>
                <td class="text-center">{{ $data['jam_kumpul'] }}</td>
                <td class="text-center">{{ $data['metode_kumpul'] }}</td>
                <td class="text-center">{{ $data['jam_ambil'] }}</td>
                <td class="text-center">{{ $data['metode_ambil'] }}</td>
                <td class="text-center">{{ $data['status_akhir'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p><strong>Keterangan:</strong></p>
        <ul>
            <li><strong>Selesai:</strong> Siswa sudah mengumpulkan dan mengambil HP</li>
            <li><strong>Belum Ambil:</strong> Siswa sudah mengumpulkan HP tapi belum mengambil</li>
            <li><strong>Belum Kumpul:</strong> Siswa belum mengumpulkan HP sama sekali</li>
        </ul>
    </div>
</body>
</html>
