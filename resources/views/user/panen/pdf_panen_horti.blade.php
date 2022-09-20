<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>panen horti pdf</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>
    <h2 style="text-align: center" >Data Panen Horti</h2>
    <table class="table table-striped ">
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
