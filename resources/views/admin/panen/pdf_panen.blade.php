<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table class="table table-bordered">
        <thead>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kecamatan</th>
            <th>Desa</th>
            <th>Tanaman </th>
            <th>Luas Panen</th>
            <th>Kadar</th>
            <th>Produksi</th>
            <th>Provitas</th>
            <th>Harga</th>
        </thead>
        <tbody>
            @foreach ($produktivitas as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                    <td>{{ $item->mst_kecamatan->nama_kecamatan }}</td>
                    <td>{{ $item->mst_desa->nama_desa }}</td>
                    <td>{{ $item->mst_tanaman->nama_tanaman }}</td>
                    <td>{{ $item->luas_lahan }} ha</td>
                    <td>{{ $item->kadar }} %</td>
                    <td>{{ $item->produksi }} ton</td>
                    <td>{{ $item->provitas }} ku/ha</td>
                    <td>Rp. {{ format_uang($item->harga) }},00</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
