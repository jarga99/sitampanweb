<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>puso horti pdf</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>
    <h2 style="text-align: center" >Data Puso Horti</h2>
    <table class="table table-striped ">
        <thead>
            <tr class="warning">
                <th rowspan="2">No</th>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">Kecamatan</th>
                <th rowspan="2">Desa</th>
                <th rowspan="2">Tanaman </th>
                <th colspan="2" style="text-align: center">Luas Puso</th>
                <th rowspan="2">Kadar</th>
                <th colspan="2" style="text-align: center">Produksi</th>
                <th rowspan="2">Provitas</th>
                <th rowspan="2">Harga</th>
            </tr>
            <tr class="warning">
                <th>Habis</th>
                <th>Blm Habis</th>
                <th>Habis</th>
                <th>Blm Habis</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produktivitas_puso as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                    <td>{{ $item->mst_kecamatan->nama_kecamatan }}</td>
                    <td>{{ $item->mst_desa->nama_desa }}</td>
                    <td>{{ $item->mst_tanaman->nama_tanaman }}</td>
                    <td>{{ $item->lh_habis }} ha</td>
                    <td>{{ $item->lh_blm_habis }} ha</td>
                    <td>{{ $item->kadar }} %</td>
                    <td>{{ $item->habis }} ton</td>
                    <td>{{ $item->blm_habis }} ton</td>
                    <td>{{ $item->provitas }} ku/ha</td>
                    <td>Rp. {{ format_uang($item->harga) }},00</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">Total :</th>
                <th >{{$total[0]->total_lh_habis}} ha</th>
                <th >{{$total[0]->total_lh_blm_habis}} ha</th>
                <th colspan="1"></th>
                <th >{{$total[0]->total_habis}} ha</th>
                <th >{{$total[0]->total_blm_habis}} ha</th>
                <th colspan="2"></th>
            </tr>
            <tr>
                <th colspan="7">Rata-Rata :</th>
                <th >{{$total[0]->avg_kadar}} %</th>
                <th colspan="2"></th>
                <th >{{$total[0]->avg_provitas}} ku/ha</th>
                <th >Rp. {{$total[0]->avg_harga}}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
