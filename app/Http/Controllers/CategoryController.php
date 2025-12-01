<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('user')->orderBy('id', 'ASC')->paginate(10);
        return view('dashboard.category.index',)->with('categories',$categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $category = new Category();
        $category->title = $request->title;
        $category->status = $request->status;
        $category->slug = Str::slug($request->title);

        $category->save();
        if ($category->save()) {
            $request->session()->flash('success', 'Kategori berhasil ditambahkan');
        } else {
            $request->session()->flash('error', 'Terjadi kesalahan saat menambahkan kategori');
        }

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $category->title = $request->title;
        $category->status = $request->status;
        $category->slug = Str::slug($request->title);

        if ($category->save()) {
            $request->session()->flash('success', 'Kategori berhasil diperbarui');
        } else {
            $request->session()->flash('error', 'Terjadi kesalahan saat memperbarui kategori');
        }

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if ($category->delete()) {
            session()->flash('success', 'Kategori berhasil dihapus');
        } else {
            session()->flash('error', 'Terjadi kesalahan saat menghapus kategori');
        }

        return redirect()->route('category.index');
    }
}
