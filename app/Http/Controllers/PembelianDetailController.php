<?php

namespace App\Http\Controllers;

use App\Models\pembelian;
use App\Models\pembelian_detail;
use App\Models\barang;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PembelianDetailExport;

class PembelianDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $pembelianDetails = pembelian_detail::with(['pembelian.supplier', 'barang'])
            ->where('id_pembelian', $id)
            ->get();
        return view('pages.pembelian_detail', compact('pembelianDetails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id_supplier' => 'required|exists:suppliers,id',
                'items' => 'required|array|min:1',
                'items.*.nama_barang' => 'required|string',
                'items.*.jumlah_beli' => 'required|integer|min:1',
            ]);

            $items = collect($request->items);
            $total = 0;

            $items = $items->map(function ($item) {
                $barang = barang::firstOrCreate(
                    ['nama_barang' => $item['nama_barang']],
                    ['stok' => 0, 'harga_beli' => 0]
                );

                $item['harga_beli'] = $item['harga_beli'] ?? $barang->harga_beli;
                if (!$item['harga_beli'] || $item['harga_beli'] <= 0) {
                    throw new \Exception('Harga_beli barang tidak valid untuk ' . $item['nama_barang']);
                }

                $item['sub_total'] = $item['jumlah_beli'] * $item['harga_beli'];
                return $item;
            });

            $total = $items->sum('sub_total');

            $pembelian = pembelian::create([
                'id_supplier' => $request->id_supplier,
                'tgl_beli' => Carbon::now()->toDateString(),
                'total' => $total
            ]);

            foreach ($items as $item) {
                $barang = barang::where('nama_barang', $item['nama_barang'])->first();

                pembelian_detail::create([
                    'id_pembelian' => $pembelian->id,
                    'id_barang' => $barang->id,
                    'jumlah_beli' => $item['jumlah_beli'],
                    'sub_total' => $item['sub_total']
                ]);

                $barang->update([
                    'stok' => $barang->stok + $item['jumlah_beli']
                ]);
            }

            DB::commit();
            return redirect('/pembelian')->with('success', 'Pembelian berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data pembelian: ' . $e->getMessage()
            ], 500);
        }
    }

    // public function export()
    // {
    //     return Excel::download(new PembelianDetailExport, 'pembelian-detail.xlsx');
    // }

    /**
     * Display the specified resource.
     */
    public function show(pembelian_detail $pembelian_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pembelian_detail $pembelian_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pembelian_detail $pembelian_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pembelian_detail $pembelian_detail)
    {
        //
    }
}
