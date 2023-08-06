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
    <h3 class='tengah'>Laporan SO barang di momopetshop</h3>
    <p class='tengah'>Periode bulan : {{ $bulan }}</p>
    <br/>
    <table>
        <tr>
            <th align="left" width="5%">No</th>
            <th align="left" width="20%">Kode Barang</th>
            <th align="left" width="30%">Nama Barang</th>
            <th align="left" width="15%">Kategori</th>
            <th align="left" width="10%">Barang Masuk</th>
            <th align="left" width="10%">Barang Keluar</th>
            <th align="left" width="10%">Stok Barang</th>
        </tr>
        @foreach ($sopp as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item['kode_barang'] }}</td>
                <td>{{ $item['nama_barang'] }}</td>
                <td>{{ $item['kategori'] }}</td>
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
