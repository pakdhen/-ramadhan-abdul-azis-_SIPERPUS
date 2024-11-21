<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookshelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Tampilkan daftar buku
    public function index()
    {
        $data['books'] = Book::all();
        return view('books.index', $data);
    }

    // Tampilkan form untuk membuat buku baru
    public function create()
    {
        $data['bookshelves'] = Bookshelf::pluck('name', 'id');
        return view('books.create', $data);
    }

    // Simpan data buku baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'year' => 'required|integer|max:2077',
            'publisher' => 'required|max:255',
            'city' => 'required|max:50',
            'cover' => 'required|image|max:2048',
            'bookshelf_id' => 'required|exists:bookshelves,id',
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->storeAs(
                'public/cover_buku',
                'cover_buku_' . time() . '.' . $request->file('cover')->extension()
            );
            $validated['cover'] = basename($path);
        }

        $book = Book::create($validated);
        $notification = $book
            ? ['message' => 'Data buku berhasil disimpan', 'alert-type' => 'success']
            : ['message' => 'Data buku gagal disimpan', 'alert-type' => 'error'];

        return redirect()->route('book')->with($notification);
    }

    // Tampilkan form untuk mengedit data buku
    public function edit($id)
    {
        $data['book'] = Book::find($id);
        if (!$data['book']) {
            abort(404, 'Data buku tidak ditemukan');
        }

        $data['bookshelves'] = Bookshelf::pluck('name', 'id');
        return view('books.edit', $data);
    }

    // Update data buku
    public function update(Request $request, $id)
    {
        $dataLama = Book::find($id);
        if (!$dataLama) {
            abort(404, 'Data buku tidak ditemukan');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'year' => 'required|integer|max:2077',
            'publisher' => 'required|max:255',
            'city' => 'required|max:50',
            'cover' => 'nullable|image|max:2048',
            'bookshelf_id' => 'required|exists:bookshelves,id',
        ]);

        if ($request->hasFile('cover')) {
            if ($dataLama->cover) {
                Storage::delete('public/cover_buku/' . $dataLama->cover);
            }
            $path = $request->file('cover')->storeAs(
                'public/cover_buku',
                'cover_buku_' . time() . '.' . $request->file('cover')->extension()
            );
            $validated['cover'] = basename($path);
        }

        $dataLama->update($validated);
        $notification = $dataLama
            ? ['message' => 'Data buku berhasil diperbarui', 'alert-type' => 'success']
            : ['message' => 'Data buku gagal diperbarui', 'alert-type' => 'error'];

        return redirect()->route('book')->with($notification);
    }

    // Hapus data buku
    public function destroy($id)
    {
        $data = Book::find($id);
        if ($data) {
            // Hapus file cover jika ada
            if ($data->cover) {
                Storage::delete('public/cover_buku/' . $data->cover);
            }
            $berhasil = $data->delete();
            $notification = $berhasil
                ? ['message' => 'Data buku berhasil dihapus', 'alert-type' => 'success']
                : ['message' => 'Data buku gagal dihapus', 'alert-type' => 'error'];
        } else {
            $notification = ['message' => 'Data buku tidak ditemukan', 'alert-type' => 'error'];
        }

        return redirect()->route('book')->with($notification);
    }
}
