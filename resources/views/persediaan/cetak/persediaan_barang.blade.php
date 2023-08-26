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
    <h3 class='tengah'>Laporan Pembelian stok barang di momopetshop</h3>
    <p class='tengah'>Periode bulan : {{ $bulan }}</p>
    <br/>
    <table>
        <tr>
            <th width="5%">No</th>
            <th width="25%">Kode barang</th>
            <th width="25%">Nama barang</th>
            <th width="15%">Kategori</th>
            <th width="10%">Jumlah</th>
            <th width="20%">Nominal</th>
        </tr>
        @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->kode_barang }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ $item->jml_brg }}</td>
                <td>Rp. {{ number_format($item->nominal_barang, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5" style="text-align: right"><strong>Total</strong></td>
            <td><strong>Rp. {{ number_format($total,0,',','.') }}</strong></td>
        </tr>
    </table>
    <p style="margin-left: 68%">{{ auth()->user()->name }}</p>
    <br><br><br><br>
    <p style="margin-left: 65%">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p>
</body>
<script>
    print()
</script>
</html>
