<?php

namespace App\Http\Controllers;

use App\Models\supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = supplier::all();
        return view('pages.supplier', compact('suppliers'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|max:255',
            'alamat_supplier' => 'required',
            'no_telp' => 'required|max:15',
        ], [
            'nama_supplier.required' => 'Nama supplier harus diisi',
            'nama_supplier.max' => 'Nama supplier maksimal 255 karakter',
            'alamat_supplier.required' => 'Alamat_supplier harus diisi',
            'no_telp.required' => 'No telepon harus diisi',
            'no_telp.max' => 'No telepon maksimal 15 karakter',
        ]);

        supplier::create($request->all());
        return redirect('/supplier')->with('success', 'Supplier berhasil ditambahkan');
    }

    public function show(supplier $supplier)
    {
        //
    }

    public function edit(supplier $supplier)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_supplier' => 'required|max:255',
            'no_telp' => 'required|max:15',
            'alamat_supplier' => 'required'
        ]);

        DB::table('suppliers')->where('id', $id)->update([
            'nama_supplier' => $request->nama_supplier,
            'no_telp' => $request->no_telp,
            'alamat_supplier' => $request->alamat_supplier
        ]);

        return redirect('/supplier')->with('success', 'Supplier berhasil diupdate');
    }

    public function destroy(supplier $id)
    {
        $id->delete();
        return redirect('/supplier')->with('success', 'Supplier berhasil dihapus');
    }
}
