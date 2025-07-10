<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BukuNonWajib;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuNonWajibController extends Controller
{
    public function index(Request $request)
    {
        $query = BukuNonWajib::with('kategori');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }
        
        // Filter by kategori
        if ($request->has('kategori_id') && $request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }
        
        $bukuNonWajib = $query->paginate(10)->withQueryString();
        $kategori = KategoriBuku::orderBy('nama')->get();
        
        return view('admin.buku-non-wajib.index', compact('bukuNonWajib', 'kategori'));
    }

    public function create()
    {
        $kategori = KategoriBuku::orderBy('nama')->get();
        return view('admin.buku-non-wajib.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_buku,id',
            'penulis' => 'nullable|string|max:255',
            'penerbit' => 'nullable|string|max:100',
            'isbn' => 'nullable|string|max:20|unique:buku_non_wajib,isbn',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
        ], [
            'judul.required' => 'Judul buku wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'isbn.unique' => 'ISBN sudah digunakan untuk buku lain.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min' => 'Tahun terbit tidak valid.',
            'tahun_terbit.max' => 'Tahun terbit tidak boleh melebihi tahun sekarang.',
            'stok.required' => 'Stok buku wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        BukuNonWajib::create($request->all());

        return redirect()->route('admin.buku-non-wajib.index')
            ->with('success', 'Buku non-wajib berhasil ditambahkan.');
    }

    public function show(BukuNonWajib $bukuNonWajib)
    {
        $bukuNonWajib->load('kategori');
        return view('admin.buku-non-wajib.show', compact('bukuNonWajib'));
    }

    public function edit(BukuNonWajib $bukuNonWajib)
    {
        $kategori = KategoriBuku::orderBy('nama')->get();
        return view('admin.buku-non-wajib.edit', compact('bukuNonWajib', 'kategori'));
    }

    public function update(Request $request, BukuNonWajib $bukuNonWajib)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_buku,id',
            'penulis' => 'nullable|string|max:255',
            'penerbit' => 'nullable|string|max:100',
            'isbn' => 'nullable|string|max:20|unique:buku_non_wajib,isbn,' . $bukuNonWajib->id,
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
        ], [
            'judul.required' => 'Judul buku wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'isbn.unique' => 'ISBN sudah digunakan untuk buku lain.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min' => 'Tahun terbit tidak valid.',
            'tahun_terbit.max' => 'Tahun terbit tidak boleh melebihi tahun sekarang.',
            'stok.required' => 'Stok buku wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $bukuNonWajib->update($request->all());

        return redirect()->route('admin.buku-non-wajib.index')
            ->with('success', 'Buku non-wajib berhasil diperbarui.');
    }

    public function destroy(BukuNonWajib $bukuNonWajib)
    {
        // Check if book is currently borrowed
        $isBeingBorrowed = $bukuNonWajib->detailPeminjaman()
            ->whereHas('peminjaman', function($query) {
                $query->where('status', 'dipinjam');
            })->exists();

        if ($isBeingBorrowed) {
            return redirect()->route('admin.buku-non-wajib.index')
                ->with('error', 'Buku tidak dapat dihapus karena sedang dipinjam.');
        }

        $bukuNonWajib->delete();

        return redirect()->route('admin.buku-non-wajib.index')
            ->with('success', 'Buku non-wajib berhasil dihapus.');
    }
}