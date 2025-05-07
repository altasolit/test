<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::get();
        return view('produk.index', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::get();
        return view('produk.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|min:3|max:255',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'nama_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        // Proses upload file
        if ($request->hasFile('nama_file')) {
            $file = $request->file('nama_file');
            $namaFile = time() . '_' . $file->getClientOriginalName(); // buat nama unik
            $file->move(public_path('img'), $namaFile); // simpan ke folder public/img
        }

        // Simpan ke database
        Produk::create([
            'nama_produk' => $validated['nama_produk'],
            'deskripsi' => $validated['deskripsi'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'nama_file' => $namaFile,
            'kategori_id' => $validated['kategori_id'],
        ]);
        // Produk::create($validated);
        return redirect()->route('produk.index');
    }
    /**
     * Validate and handle the incoming request for storing a new product.
     */

    /**
     * Display the specified resource.
     */
    public function show(produk $produk)
    {
        $produk = Produk::with('kategori')->findOrFail($produk);

        return response()->json([
            'nama_produk' => $produk->nama_produk,
            'deskripsi' => $produk->deskripsi,
            'harga' => $produk->harga,
            'stok' => $produk->stok,
            'kategori' => $produk->kategori->nama_kategori,
            'foto' => $produk->nama_file ? asset('img/' . $produk->nama_file) : null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(produk $produk)
    {
        $kategori = Kategori::get(); // Supaya dropdown kategori muncul
        return view('produk.edit', compact('produk', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, produk $produk)
    {

        $validated = $request->validate([
            'nama_produk' => 'required|min:3|max:255',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Jika ada file baru di-upload, simpan file baru
        if ($request->hasFile('nama_file')) {
            $file = $request->file('nama_file');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img'), $namaFile);
            $validated['nama_file'] = $namaFile;
        }

        // Update produk
        $produk->update($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(produk $produk)
    {
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'produk deleted successfully.');
    }
}
