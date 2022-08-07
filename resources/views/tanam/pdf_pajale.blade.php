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
            <th>Luas Tanam</th>
            {{-- <th>Nama Penginput</th> --}}
        </thead>
        <tbody>
            @foreach ($produktivitas_tanam as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at) }}</td>
                    <td>{{ $item->mst_kecamatan->nama_kecamatan }}</td>
                    <td>{{ $item->mst_desa->nama_desa }}</td>
                    <td>{{ $item->mst_tanaman->nama_tanaman }}</td>
                    <td>{{ $item->luas_lahan }}</td>
                    {{-- <td>{{ $item->user->nama }}</td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
