<?php

namespace App\Exports;

use App\Models\pembelian_detail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PembelianDetailExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return pembelian_detail::with(['barang'])
            ->get()
            ->map(function($detail) {
                return [
                    'ID Pembelian' => $detail->id_pembelian,
                    'Nama Barang' => $detail->barang->nama_barang,
                    'Jumlah Beli' => $detail->jumlah_beli,
                    'Sub Total' => $detail->sub_total,
                    'Tanggal' => $detail->created_at->format('d/m/Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID Pembelian',
            'Nama Barang',
            'Jumlah Beli',
            'Sub Total',
            'Tanggal',
        ];
    }
}
