<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});
// Route::GET('/data/panen/{id}', function (){
//     $id_panen = request()->route('id');
//     $total = DB::select(DB::raw("
//         SELECT
//             id_produktivitas,
//             tb_produktivitas.updated_at AS updated_at,
//             SUM(luas_lahan) AS luas_lahan,
//             ROUND(kadar/100,2) AS kadar,
//             produksi,
//             harga,
//             nama_kecamatan,
//             nama_desa,
//             nama_tanaman,
//             provitas,
//             tb_user.nama,
//             luas_lahan,(
//                 SELECT SUM(luas_lahan) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
//                 WHERE jenis_panen = $id_panen
//             ) as total_luas_lahan,(
//                 SELECT ROUND(AVG(kadar)/100,2) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
//                 WHERE jenis_panen = $id_panen
//             ) as avg_kadar,(
//                 SELECT AVG(produksi) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
//                 WHERE jenis_panen = $id_panen
//             ) AS avg_produktivitas,(
//                 SELECT AVG(provitas) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
//                 WHERE jenis_panen = $id_panen
//             ) AS avg_provitas,(
//                 SELECT SUM(harga) FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
//                 WHERE jenis_panen = $id_panen
//             ) AS total_harga
//         FROM tb_produktivitas INNER JOIN mst_tanaman ON tanaman_id = id_tanaman
//         INNER JOIN mst_kecamatan ON id_kecamatan = kecamatan_id
//         INNER JOIN mst_desa ON id_desa = desa_id
//         INNER JOIN tb_user ON tb_user.id_user = created_by
//         WHERE jenis_panen = $id_panen
//         AND tb_produktivitas.updated_at >= (now() -interval 5 year)
//         GROUP BY id_produktivitas
//     "));
//     // $id_panen = request()->route('id');
//     $response = array(
//         "id_panen" => $id_panen,
//         "datas" => $total
//     );
//     return response()->json($response, 200);
// });
