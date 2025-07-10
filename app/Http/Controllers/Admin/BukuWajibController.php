<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BukuWajib;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuWajibController extends Controller
{
    public function index(Request $request)
    {
        $query = BukuWajib::query();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('mata_pelajaran', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }
        
        // Filter by tingkat
        if ($request->has('tingkat') && $request->tingkat) {
            $query->where('tingkat', $request->tingkat);
        }
        
        // Filter by mata pelajaran
        if ($request->has('mata_pelajaran') && $request->mata_pelajaran) {
            $query->where('mata_pelajaran', $request->mata_pelajaran);
        }
        
        $bukuWajib = $query->paginate(10)->withQueryString();
        $tingkatList = ['7', '8', '9'];
        $mataPelajaran = BukuWajib::distinct()->pluck('mata_pelajaran')->filter();
        
        return view('admin.buku-wajib.index', compact('bukuWajib', 'tingkatList', 'mataPelajaran'));
    }

    public function create()
    {
        $tingkatList = ['7', '8', '9'];
        return view('admin.buku-wajib.create', compact('tingkatList'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:100',
            'tingkat' => 'required|in:7,8,9',
            'penerbit' => 'nullable|string|max:100',
            'isbn' => 'nullable|string|max:20|unique:buku_wajib,isbn',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
        ], [
            'judul.required' => 'Judul buku wajib diisi.',
            'mata_pelajaran.required' => 'Mata pelajaran wajib diisi.',
            'tingkat.required' => 'Tingkat kelas wajib dipilih.',
            'tingkat.in' => 'Tingkat kelas harus 7, 8, atau 9.',
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

        BukuWajib::create($request->all());

        return redirect()->route('admin.buku-wajib.index')
            ->with('success', 'Buku wajib berhasil ditambahkan.');
    }

    public function show(BukuWajib $bukuWajib)
    {
        return view('admin.buku-wajib.show', compact('bukuWajib'));
    }

    public function edit(BukuWajib $bukuWajib)
    {
        $tingkatList = ['7', '8', '9'];
        return view('admin.buku-wajib.edit', compact('bukuWajib', 'tingkatList'));
    }

    public function update(Request $request, BukuWajib $bukuWajib)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'mata_pelajaran' => 'required|string|max:100',
            'tingkat' => 'required|in:7,8,9',
            'penerbit' => 'nullable|string|max:100',
            'isbn' => 'nullable|string|max:20|unique:buku_wajib,isbn,' . $bukuWajib->id,
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
        ], [
            'judul.required' => 'Judul buku wajib diisi.',
            'mata_pelajaran.required' => 'Mata pelajaran wajib diisi.',
            'tingkat.required' => 'Tingkat kelas wajib dipilih.',
            'tingkat.in' => 'Tingkat kelas harus 7, 8, atau 9.',
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

        $bukuWajib->update($request->all());

        return redirect()->route('admin.buku-wajib.index')
            ->with('success', 'Buku wajib berhasil diperbarui.');
    }

    public function destroy(BukuWajib $bukuWajib)
    {
        // Check if book is currently borrowed
        $isBeingBorrowed = $bukuWajib->detailPeminjaman()
            ->whereHas('peminjaman', function($query) {
                $query->where('status', 'dipinjam');
            })->exists();

        if ($isBeingBorrowed) {
            return redirect()->route('admin.buku-wajib.index')
                ->with('error', 'Buku tidak dapat dihapus karena sedang dipinjam.');
        }

        $bukuWajib->delete();

        return redirect()->route('admin.buku-wajib.index')
            ->with('success', 'Buku wajib berhasil dihapus.');
    }
}