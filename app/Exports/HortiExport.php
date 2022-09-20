<?php

namespace App\Exports;

use App\Models\Produktivitas;
use App\Models\Tanaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;

class HortiExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithMapping
{
    use Exportable;

    public function setDari($dari = null)
    {
        $this->dari = $dari;

        return $this;
    }

    public function setSampai($sampai = null)
    {
        $this->sampai = $sampai;

        return $this;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kecamatan',
            'Desa',
            'Tanaman',
            'Luas Panen',
            'Kadar',
            'Produksi',
            'Provitas',
            'Harga',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:I9';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
            },
        ];
    }

    public function map($item): array
    {
        return [
            \Carbon\Carbon::parse($item->created_at)->format('d-m-Y'),
            $item->mst_kecamatan->nama_kecamatan,
            $item->mst_desa->nama_desa,
            $item->mst_tanaman->nama_tanaman,
            $item->luas_lahan. ' ha',
            $item->kadar.' %',
            $item->produksi.' ton',
            $item->provitas.' ku/ha',
    'Rp. '. format_uang ($item ->harga).',00',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $tanaman = Tanaman::where('jenis_panen', 2)->pluck('id_tanaman');
        $data =  Produktivitas::with('mst_tanaman', 'mst_kecamatan', 'mst_desa', 'user')->whereIn('tanaman_id', $tanaman);

        if($this->dari != null && $this->sampai != null) {
            $produktivitas = $data->whereBetween('created_at', [$this->dari, $this->sampai])->get();
        } else {
            $produktivitas = $data->get();
        }

        return $produktivitas;
    }
}
