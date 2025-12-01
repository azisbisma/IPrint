<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner=Banner::orderBy('id','DESC')->paginate(10);
        return view('dashboard.banner.index',)->with('banners',$banner);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'string|required|max:50',
            'description' => 'string|nullable',
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Penanganan unggahan file
        $photo = $request->file('photo');
        $filename = date('Y-m-d') . '-' . $photo->getClientOriginalName();
        $path = 'photo-banner/' .$filename;

        Storage::disk('public')->put($path,file_get_contents($photo));

        // Menetapkan data permintaan ke array banner
        $banner['title'] = $request->title;
        $banner['description'] = $request->description;
        $banner['status'] = $request->status;
        $banner['photo'] = $filename;

        // Penambahan slug
        $slug=Str::slug($request->title);
        $count=Banner::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $banner['slug']=$slug;
        
        // Membuat banner
        $createdBanner = Banner::create($banner);

        if ($createdBanner) {
            $request->session()->flash('success', 'Banner berhasil ditambahkan');
        } else {
            $request->session()->flash('error', 'Terjadi kesalahan saat menambahkan banner');
        }

        return redirect()->route('banner.index');
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
        $banner=Banner::findOrFail($id);
        if($banner){
            return view('dashboard.banner.edit')->with('banner',$banner);
        }
        else{
            return back()->with('gagal','data tidak ditemukan');
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $banner = Banner::findOrFail($id);
        $validator = Validator::make($request->all(), [
        'title' => 'string|required|max:50',
        'description' => 'string|nullable',
        'photo' => 'image|mimes:png,jpg,jpeg|max:2048',
        'status' => 'required|in:aktif,nonaktif',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Mengubah data banner berdasarkan permintaan
    $banner->title = $request->title;
    $banner->description = $request->description;
    $banner->status = $request->status;

    // Mengunggah foto jika ada yang dipilih
    if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = date('Y-m-d') . '-' . $photo->getClientOriginalName();
            $path = 'photo-banner/' . $filename;

            Storage::disk('public')->put($path, file_get_contents($photo));

            // Menghapus foto lama jika ada
            if ($banner->photo) {
                Storage::disk('public')->delete('photo-banner/' . $banner->photo);
            }

        $banner->photo = $filename;
    }

    // Menyimpan perubahan banner
    $updated = $banner->save();

    if ($updated) {
        $request->session()->flash('success', 'Banner berhasil diperbarui');
    } else {
        $request->session()->flash('error', 'Terjadi kesalahan saat memperbarui banner');
    }

    return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->delete()) {
            session()->flash('success', 'Banner berhasil dihapus');
        } else {
            session()->flash('error', 'Terjadi kesalahan saat menghapus banner');
        }

        return redirect()->route('banner.index');
    }
}
