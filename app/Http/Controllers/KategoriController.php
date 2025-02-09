<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = kategori::all();
        return view('pages.kategori', compact('kategoris'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100|unique:kategoris'
        ], [
            'nama_kategori.required' => 'Nama kategori harus diisi',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter',
            'nama_kategori.unique' => 'Nama kategori sudah ada'
        ]);

        kategori::create($request->all());
        return redirect('/kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function show(kategori $kategori)
    {
        //
    }

    public function edit(kategori $kategori)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100|unique:kategoris,nama_kategori,'
        ], [
            'nama_kategori.required' => 'Nama kategori harus diisi',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter',
            'nama_kategori.unique' => 'Nama kategori sudah ada'
        ]);

        DB::table('kategoris')->where('id', $id)->update([
            'nama_kategori' => $request->nama_kategori
        ]);
        return redirect('/kategori')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(kategori $id)
    {
        $id->delete();
        return redirect('/kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
