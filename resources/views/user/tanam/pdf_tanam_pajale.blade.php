<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>tanam pajale pdf</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <h2 style="text-align: center" >Data Tanam Pajale</h2>
    <table class="table table-striped ">
        <thead>
            <tr class="success">
                <th>No</th>
                <th>Tanggal</th>
                <th>Kecamatan</th>
                <th>Desa</th>
                <th>Tanaman </th>
                <th>Luas Tanam</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produktivitas_tanam as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                    <td>{{ $item->mst_kecamatan->nama_kecamatan }}</td>
                    <td>{{ $item->mst_desa->nama_desa }}</td>
                    <td>{{ $item->mst_tanaman->nama_tanaman }}</td>
                    <td>{{ $item->luas_lahan }} ha</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">Total :</th>
                <th >{{$total[0]->total_luas_lahan}} ha</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
