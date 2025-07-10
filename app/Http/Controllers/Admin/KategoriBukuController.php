<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriBukuController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriBuku::withCount('bukuNonWajib');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%");
        }
        
        $kategori = $query->paginate(10)->withQueryString();
        
        return view('admin.kategori-buku.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori-buku.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100|unique:kategori_buku,nama',
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Nama kategori sudah ada.',
            'nama.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        KategoriBuku::create($request->all());

        return redirect()->route('admin.kategori-buku.index')
            ->with('success', 'Kategori buku berhasil ditambahkan.');
    }

    public function show(KategoriBuku $kategoriBuku)
    {
        $kategoriBuku->loadCount('bukuNonWajib');
        $bukuNonWajib = $kategoriBuku->bukuNonWajib()->paginate(10);
        
        return view('admin.kategori-buku.show', compact('kategoriBuku', 'bukuNonWajib'));
    }

    public function edit(KategoriBuku $kategoriBuku)
    {
        return view('admin.kategori-buku.edit', compact('kategoriBuku'));
    }

    public function update(Request $request, KategoriBuku $kategoriBuku)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100|unique:kategori_buku,nama,' . $kategoriBuku->id,
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Nama kategori sudah ada.',
            'nama.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kategoriBuku->update($request->all());

        return redirect()->route('admin.kategori-buku.index')
            ->with('success', 'Kategori buku berhasil diperbarui.');
    }

    public function destroy(KategoriBuku $kategoriBuku)
    {
        // Check if category has books
        if ($kategoriBuku->bukuNonWajib()->count() > 0) {
            return redirect()->route('admin.kategori-buku.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki buku.');
        }

        $kategoriBuku->delete();

        return redirect()->route('admin.kategori-buku.index')
            ->with('success', 'Kategori buku berhasil dihapus.');
    }
}