<!DOCTYPE html>
<html>
<head>
    <title>Data Export</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; table-layout: fixed; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; font-size: 11px; vertical-align: top; word-wrap: break-word; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        h2 { text-align: center; margin-bottom: 5px; }
        .meta { text-align: center; font-size: 12px; margin-bottom: 20px; color: #555; }
    </style>
</head>
<body>
    <h2>Data Mahasiswa {{ $filter_prodi ? '- ' . $filter_prodi : '' }}</h2>
    <div class="meta">Dicetak pada: {{ date('d-m-Y H:i') }}</div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 25%">Nama Lengkap</th>
                <th style="width: 20%">Prodi Pilihan</th>
                <th style="width: 20%">Asal Sekolah</th>
                <th style="width: 15%">Status</th>
                <th style="width: 15%">Jenjang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $student->nama }}</strong><br>
                    <span style="color: #555;">{{ $student->user->email ?? '-' }}</span>
                </td>
                <td>{{ $student->prodi->nama_prodi ?? '-' }}</td>
                <td>{{ $student->asal_sekolah }}</td>
                <td style="text-align: center;">
                    @if($student->status_seleksi == 'lolos')
                        <span style="color: green; font-weight: bold;">DITERIMA</span>
                    @elseif($student->status_seleksi == 'tidak_lolos')
                        <span style="color: red; font-weight: bold;">DITOLAK</span>
                    @else
                        <span style="color: orange; font-weight: bold;">PENDING</span>
                    @endif
                </td>
                <td style="text-align: center;">{{ $student->prodi->jenjang ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
