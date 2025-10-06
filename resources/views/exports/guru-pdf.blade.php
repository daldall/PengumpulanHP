<!DOCTYPE html>
<html>
<head>
    <title>Daftar Guru</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Daftar Guru</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guru as $index => $g)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $g->name }}</td>
                <td>{{ $g->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
