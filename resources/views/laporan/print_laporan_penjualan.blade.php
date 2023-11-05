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
    <h3 class='tengah'>Laporan Pendapatan Penjualan di momopetshop</h3>
    <p class='tengah'>Periode tanggal : {{ date('d/m/Y', strtotime($awal)) }} s/d {{ date('d/m/Y', strtotime($akhir)) }}</p>
    <br/>
    <table>
        <tr>
            <th align="left" width="5%">No</th>
            <th align="left" width="20%">ID</th>
            <th align="left" width="10%">Customer</th>
            <th align="left" width="15%">Total barang</th>
            <th align="left" width="15%">Tanggal transaksi</th>
            <th align="left" width="10%">Status</th>
            <th align="left" width="15%">Total bayar</th>
        </tr>
        @foreach ($orders as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->total_jumlah }}</td>
                <td>{{ date('d M Y', strtotime($item->tgl_transaksi)) }}</td>
                <td>
                    @if ($item->status == 1)
                        Selesai
                    @else
                        Proses
                    @endif
                </td>
                <td>Rp. {{ number_format($item->total_harga, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6" style="text-align: right"><strong>Total</strong></td>
            <td><strong>Rp. {{ number_format($total_penjualan,0,',','.') }}</strong></td>
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
