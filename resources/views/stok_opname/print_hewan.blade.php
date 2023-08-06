<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body>
    <style type="text/css">
        body{
        font-family: sans-serif;
        }
        table{
        margin: 20px auto;
        border-collapse: collapse;
        }
        table th,
        table td{
        border: 1px solid #3c3c3c;
        padding: 3px 8px;
        }
        .tengah{
            text-align: center;
        }
    </style>
    <h2 class='tengah'>MOMOPETSHOP</h2>
    <h3 class='tengah'>Laporan SO hewan di momopetshop</h3>
    <p class='tengah'>Periode bulan : {{ $bulan }}</p>
    <br/>
    <table>
        <tr>
            <th align="left" width="5%">No</th>
            <th align="left" width="15%">Kode</th>
            <th align="left" width="35%">Nama hewan</th>
            <th align="left" width="15%">hewan Masuk</th>
            <th align="left" width="15%">hewan Keluar</th>
            <th align="left" width="15%">Stok hewan</th>
        </tr>
        @foreach ($soh as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item['kode_hewan'] }}</td>
                <td>{{ $item['nama_hewan'] }}</td>
                <td>{{ $item['masuk'] }}</td>
                <td>{{ $item['keluar'] }}</td>
                <td>{{ $item['masuk']-$item['keluar'] }}</td>
            </tr>
        @endforeach
    </table>
    <p style="margin-left: 68%">{{ auth()->user()->name }}</p>
    <br><br><br><br>
    <p style="margin-left: 65%">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p>
</body>
<script>
    print()
</script>
</html>
