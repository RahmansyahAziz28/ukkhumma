<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\penjualan;
use App\Models\penjualan_detail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PenjualanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $barang = barang::all();
        $penjualan = penjualan_detail::all()
        ->where('id_penjualan', $id);
        return view('pages.penjualan_detail', compact('penjualan', 'barang'));

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
                'id_member' => 'required',
                'batas_waktu' => 'required',
                'items' => 'required|array|min:1',
                'items.*.nama_barang' => 'required|string',
                'items.*.jumlah_jual' => 'required|integer|min:1',
                'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'required',
                'no_resi' => 'required'
            ]);

            $items = collect($request->items);
            $total = 0;

            $items = $items->map(function ($item) {
                $barang = Barang::where('nama_barang', $item['nama_barang'])->firstOrFail();

                $item['harga_jual'] = $barang->harga_jual;
                if (!$item['harga_jual'] || $item['harga_jual'] <= 0) {
                    throw new \Exception('Harga_jual barang tidak valid untuk ' . $item['nama_barang']);
                }

                $item['sub_total'] = $item['jumlah_jual'] * $item['harga_jual'];
                return $item;
            });


            $total = $items->sum('sub_total');

            foreach ($items as $item) {
                $barang = Barang::where('nama_barang', $item['nama_barang'])->first();

                if (!$barang || $barang->stok < $item['jumlah_jual']) {
                    throw new \Exception("Stok tidak mencukupi untuk {$item['nama_barang']}");
                }

                $item['sub_total'] = $item['jumlah_jual'] * $barang->harga_jual;
                $total += $item['sub_total'];
            }

            $fileName = null;
            if ($request->hasFile('bukti_bayar')) {
                $fileName = 'bukti_bayar-' . uniqid() . '.' . $request->bukti_bayar->extension();
                $request->bukti_bayar->move(public_path('image'), $fileName);
            }

            $penjualan = Penjualan::create([
                'id_member' => $request->id_member,
                'waktu' => Carbon::now()->toDateTimeString(),
                'batas_waktu' => $request->batas_waktu,
                'total' => $total,
                'bukti_bayar' => $fileName,
                'status' => $request->status,
                'no_resi' => $request->no_resi
            ]);

            foreach ($items as $item) {
                $barang = Barang::where('nama_barang', $item['nama_barang'])->first();

                penjualan_detail::create([
                    'id_penjualan' => $penjualan->id,
                    'id_barang' => $barang->id,
                    'jumlah_jual' => $item['jumlah_jual'],
                    'sub_total' => $item['sub_total']
                ]);

                $barang->update([
                    'stok' => $barang->stok - $item['jumlah_jual']
                ]);
            }

            DB::commit();
            return redirect()->route('penjualan')->with('success', 'Penjualan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data penjualan: '. $items . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(penjualan_detail $penjualan_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(penjualan_detail $penjualan_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, penjualan_detail $penjualan_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(penjualan_detail $penjualan_detail)
    {
        //
    }
}
