<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product=Product::orderBy('id','DESC')->paginate(10);
        return view('dashboard.product.index',)->with('products',$product);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brand=Brand::get();
        $categories = Category::all();
        // return $category;
        return view('dashboard.product.create')->with('categories',$categories)->with('brands',$brand);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'string|required',
            'summary'=>'string|required',
            'description' => 'string|nullable',
            'weight' => 'numeric|required',
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'stock' => 'numeric|required',
            'condition'=>'required|in:bekas,baru',
            'status' => 'required|in:aktif,nonaktif',
            'price' => 'numeric|required',
            'discount' => 'numeric|nullable',
            'cat_id'=>'required|exists:categories,id',
            'brand_id'=>'nullable|exists:brands,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Penanganan unggahan file
        $photo = $request->file('photo');
        $filename = date('Y-m-d') . '-' . $photo->getClientOriginalName();
        $path = 'photo-product/' .$filename;

        Storage::disk('public')->put($path,file_get_contents($photo));

        // Menetapkan data permintaan ke array banner
        $productData = $request->all();
        $productData['photo'] = $filename;
        $productData['discount'] = $request->discount ?? 0.00;
        $productData['summary'] = Purifier::clean($request->summary);
        $productData['description'] = Purifier::clean($request->description);

        // Penambahan slug
        $slug=Str::slug($request->title);
        $count=Product::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $productData['slug'] = $slug;

        // Membuat product
        $createdProduct = Product::create($productData);

        if ($createdProduct) {
            $request->session()->flash('success', 'Produk berhasil ditambahkan');
        } else {
            $request->session()->flash('error', 'Terjadi kesalahan saat menambahkan produk');
        }

        return redirect()->route('product.index');
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
        $brand=Brand::get();
        $product=Product::findOrFail($id);
        $categories = Category::all();
        $items=Product::where('id',$id)->get();
        // return $items;
        return view('dashboard.product.edit')->with('product',$product)
                    ->with('brands',$brand)
                    ->with('categories',$categories)->with('items',$items);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'weight' => 'numeric|required',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'stock' => 'numeric|required',
            'condition' => 'required|in:bekas,baru',
            'status' => 'required|in:aktif,nonaktif',
            'price' => 'numeric|required',
            'discount' => 'numeric|nullable',
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $productData = $request->all();
        $productData['description'] = Purifier::clean($request->description);
        $productData['summary'] = Purifier::clean($request->summary);

        if ($request->stock == 0) {
            $productData['status'] = 'nonaktif';
        } else {
            $productData['status'] = 'aktif';
        }
        
        $productData['discount'] = $request->discount ?? 0.00;

        // Mengunggah foto jika ada yang dipilih
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = date('Y-m-d') . '-' . $photo->getClientOriginalName();
            $path = 'photo-product/' . $filename;

            Storage::disk('public')->put($path, file_get_contents($photo));

            // Menghapus foto lama jika ada
            if ($product->photo) {
                Storage::disk('public')->delete($product->photo);
            }

            $productData['photo'] = $filename;
        }
        
        $slug = Str::slug($request->title);
        $count = Product::where('slug', $slug)->where('id', '!=', $id)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $productData['slug'] = $slug;

        // Menyimpan perubahan product
        $updated = $product->update($productData);

        if ($updated) {
            $request->session()->flash('success', 'Produk berhasil diperbarui');
        } else {
            $request->session()->flash('error', 'Terjadi kesalahan saat memperbarui produk');
        }

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Menghapus foto lama jika ada
        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }

        if ($product->delete()) {
            session()->flash('success', 'Produk berhasil dihapus');
        } else {
            session()->flash('error', 'Terjadi kesalahan saat menghapus produk');
        }
        return redirect()->route('product.index');
    }
}
