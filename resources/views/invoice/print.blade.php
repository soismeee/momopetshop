<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Struk</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th colspan="3"><h4>MOMOPETSHOP</h4></th>
            </tr>
            <tr>
                <th colspan="3">
                    <hr size="2px" color="black" />
                </th>
            </tr>
            <tr>
                <th colspan="3" style="text-align: right"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tgl : {{ date('d/m/Y', strtotime($transaksi->tgl_transaksi)) }}</th>
            </tr>
            <tr>
                <th colspan="3"><br></th>
            </tr>
            <tr>
                <th colspan="3" style="text-align: left">#{{ $transaksi->id }}</th>
            </tr>
            <tr>
                <th colspan="3"><hr></th>
            </tr>
            <tr>
                <th style="text-align: left">barang</th>
                <th style="text-align: left">Jml</th>
                <th style="text-align: left">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $data)
                <tr>
                    <td>{{ $data->nama }}</td>
                    <td style="text-align: center">{{ $data->jumlah }}</td>
                    <td>Rp. {{ number_format($data->harga*$data->jumlah,0, ',','.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><hr></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td>Rp. {{ number_format($transaksi->total_harga,0, ',','.') }}</td>
            </tr>
            <tr>
                <td colspan="3"><br></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center">Terima Kasih</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center">Telah berbelanja di momopetshop</td>
            </tr>
            <tr>
                <td colspan="3"><hr /><hr /></td>
            </tr>
        </tbody>
    </table>
</body>
<script>
    print()
</script>
</html>
