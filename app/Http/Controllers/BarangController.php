<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $penjualan = DB::table('penjualans')->sum('total');
        $pembelian = DB::table('pembelians')->sum('total');
        $totalRevenue = $penjualan - $pembelian;
        $totalmember = User::all()->where('hak_akses', 'member')->count();
        $totalorder = DB::table('penjualans')->count();
        $barang = barang::all();
        $kategoris = kategori::all();
        return view('pages.dashboard', compact('barang', 'kategoris', 'totalmember', 'totalorder', 'totalRevenue'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.addBarang', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['berat' => str_replace(',','.', $request->berat)]);

        $request->validate([
            'id_kategori' => 'required',
            'nama_barang' => 'required',
            'detail_barang' => 'required',
            'berat' => 'required',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'foto' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'stok' => 'required|numeric|min:0'
        ],
        [
            'id_kategori.required' => 'Kategori harus diisi',
            'nama_barang.required' => 'Nama barang harus diisi',
            'detail_barang.required' => 'Detail barang harus diisi',
            'berat.required' => 'Berat harus diisi',
            'harga_beli.required' => 'Harga beli harus diisi',
            'harga_beli.numeric' => 'Harga beli harus berupa angka',
            'harga_jual.required' => 'Harga jual harus diisi',
            'harga_jual.numeric' => 'Harga jual harus berupa angka',
            'foto.required' => 'Foto harus diupload',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format foto harus jpg, png, jpeg, gif, atau svg',
            'stok.required' => 'Stok harus diisi',
            'stok.numeric' => 'Stok harus berupa angka',
            'stok.min' => 'Stok minimal 0'
        ]);

        if (!empty($request->foto)) {
            $fileName = 'foto-' . uniqid() . '.' . $request->foto->extension();
            $request->foto->move(public_path('image'), $fileName);
        } else {
            $fileName = '';
        }

        DB::table('barangs')->insert([
            'id_kategori' => $request->id_kategori,
            'nama_barang' => $request->nama_barang,
            'detail_barang' => $request->detail_barang,
            'harga_jual' => $request->harga_jual ?? 0,
            'harga_beli' => $request->harga_beli ?? 0,
            'berat'=> $request->berat,
            'foto'=> $fileName,
            'stok' => $request->stok ?? 0
        ]);

        return redirect('/dashboard')->with('success', 'Data barang berhasil ditambahkan');
    }

    public function new(Request $request)
    {
        $request->merge(['berat' => str_replace(',', '.', $request->berat)]);

        $request->validate(
            [
                'id_kategori' => 'required',
                'nama_barang' => 'required',
                'detail_barang' => 'required',
                'berat' => 'required',
                'harga_beli' => 'required|numeric|min:0',
                'harga_jual' => 'required|numeric|min:0',
                'foto' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'stok' => 'required|numeric|min:0'
            ],
            [
                'id_kategori.required' => 'Kategori harus diisi',
                'nama_barang.required' => 'Nama barang harus diisi',
                'detail_barang.required' => 'Detail barang harus diisi',
                'berat.required' => 'Berat harus diisi',
                'harga_beli.required' => 'Harga beli harus diisi',
                'harga_beli.numeric' => 'Harga beli harus berupa angka',
                'harga_jual.required' => 'Harga jual harus diisi',
                'harga_jual.numeric' => 'Harga jual harus berupa angka',
                'foto.required' => 'Foto harus diupload',
                'foto.image' => 'File harus berupa gambar',
                'foto.mimes' => 'Format foto harus jpg, png, jpeg, gif, atau svg',
                'stok.required' => 'Stok harus diisi',
                'stok.numeric' => 'Stok harus berupa angka',
                'stok.min' => 'Stok minimal 0'
            ]
        );

        if (!empty($request->foto)) {
            $fileName = 'foto-' . uniqid() . '.' . $request->foto->extension();
            $request->foto->move(public_path('image'), $fileName);
        } else {
            $fileName = '';
        }

        DB::table('barangs')->insert([
            'id_kategori' => $request->id_kategori,
            'nama_barang' => $request->nama_barang,
            'detail_barang' => $request->detail_barang,
            'harga_jual' => $request->harga_jual ?? 0,
            'harga_beli' => $request->harga_beli ?? 0,
            'berat' => $request->berat,
            'foto' => $fileName,
            'stok' => $request->stok ?? 0
        ]);

        return redirect('/pembelian')->with('success', 'Data barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barang = barang::findOrFail($id);
        $kategoris = kategori::all();
        return view('pages.editBarang', compact('barang', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $request->merge(['berat' => str_replace(',','.', $request->berat)]);

        $request->validate([
            'id_kategori' => 'required',
            'nama_barang' => 'required',
            'detail_barang' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'berat' => 'required',
            'foto' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $barang = barang::findOrFail($id);

        if ($request->hasFile('foto')) {
            if ($barang->foto && file_exists(public_path('image/' . $barang->foto))) {
                unlink(public_path('image/' . $barang->foto));
            }

            $fileName = 'foto-' . uniqid() . '.' . $request->foto->extension();
            $request->foto->move(public_path('image'), $fileName);
        } else {
            $fileName = $barang->foto;
        }

        $barang->update([
            'id_kategori' => $request->id_kategori,
            'nama_barang' => $request->nama_barang,
            'detail_barang' => $request->detail_barang,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'berat' => $request->berat,
            'foto' => $fileName,

        ]);

        return redirect('/dashboard')->with('success', 'Data barang berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $barang = barang::findOrFail($id);

            if ($barang->foto && file_exists(public_path('image/' . $barang->foto))) {
                unlink(public_path('image/' . $barang->foto));
            }

            $barang->delete();
            return redirect()->back()->with('success', 'Data barang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data barang');
        }
    }
}
