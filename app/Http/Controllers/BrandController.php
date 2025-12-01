<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::orderBy('id', 'ASC')->paginate(10);
        return view('dashboard.brand.index')->with('brands', $brands);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|required|max:50|unique:brands,title',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Menetapkan data permintaan ke array brand
        $brand['title'] = $request->title;
        $brand['status']= $request->status;

        // Penambahan slug
        $slug = Str::slug($request->title);
        $count = Brand::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $brand['slug'] = $slug;

        // Membuat brand
        $createdBrand = Brand::create($brand);

        if ($createdBrand) {
            $request->session()->flash('success', 'Merek berhasil ditambahkan');
        } else {
            $request->session()->flash('error', 'Terjadi kesalahan saat menambahkan merek');
        }

        return redirect()->route('brand.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('dashboard.brand.show')->with('brand', $brand);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('dashboard.brand.edit')->with('brand', $brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'string|required|max:50|unique:brands,title,' . $id,
            'status' => 'required|in:aktif,nonaktif'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mengubah data brand berdasarkan permintaan
        $brand->title = $request->title;
        $brand->status = $request->status;

        // Penambahan slug
        $slug = Str::slug($request->title);
        $count = Brand::where('slug', $slug)->where('id', '!=', $id)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $brand->slug = $slug;

        // Menyimpan perubahan brand
        $updated = $brand->save();

        if ($updated) {
            $request->session()->flash('success', 'Merek berhasil diperbarui');
        } else {
            $request->session()->flash('error', 'Terjadi kesalahan saat memperbarui merek');
        }

        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->delete()) {
            session()->flash('success', 'Merek berhasil dihapus');
        } else {
            session()->flash('error', 'Terjadi kesalahan saat menghapus merek');
        }

        return redirect()->route('brand.index');
    }
}
