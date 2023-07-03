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
    <p class='tengah'>Periode bulan : {{ date('m/Y', strtotime($bulan)) }}</p>
    <br/>
    <table>
        <tr>
            <th align="left" width="5%">No</th>
            <th align="left" width="35%">Nama hewan</th>
            <th align="left" width="20%">hewan Masuk</th>
            <th align="left" width="20%">hewan Keluar</th>
            <th align="left" width="20%">Stok hewan</th>
        </tr>
        @foreach ($soh as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item['nama_hewan'] }}</td>
                <td>{{ $item['masuk'] }}</td>
                <td>{{ $item['keluar'] }}</td>
                <td>{{ $item['masuk']-$item['keluar'] }}</td>
            </tr>
        @endforeach
    </table>
</body>
<script>
    print()
</script>
</html>