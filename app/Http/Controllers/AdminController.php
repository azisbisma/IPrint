<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    public function admin(Request $request) {
        // Get the filter from the request
        $filter = $request->input('filter', 'today'); // Default to 'today'
        $filter = $request->input('filter', 'tahun'); // Default ke 'tahun'
        
        // Set the date range based on the filter
        switch ($filter) {
            case 'bulan':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'tahun':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            case 'hari':
            default:
                $startDate = Carbon::now()->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                break;
        }
    
        // Get the filtered orders
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('id', 'DESC')
            ->get();
    
        $totalOrders = $orders->count();

        $totalRevenue = $orders->sum('total_amount');
        $totalUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();

        $products = Product::where('stock', '<', 5)->paginate(10);

        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $startOfMonth = Carbon::now()->startOfYear()->addMonths($i - 1)->startOfMonth();
            $endOfMonth = Carbon::now()->startOfYear()->addMonths($i - 1)->endOfMonth();
            
            $monthlyRevenue[] = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                    ->sum('total_amount');
        }
        
        return view('dashboard.index', compact('orders', 'products', 'totalOrders','totalRevenue','totalUsers','filter','monthlyRevenue'));
    }
    public function adminSetting(){
        $admin = Auth::guard('admin')->user();
        
        return view('dashboard.admin-setting', compact('admin'));
    }
    public function adminEdit(Request $request, $id){
        $request->validate([
            'name' => 'string|required|max:30',
            'photo' => 'image|mimes:png,jpg,jpeg',
            'phone' => 'string|required',
        ]);
        $admin = Admin::findOrFail($id);
    
        // Update user information
        $admin->name = $request->name;
        $admin->phone = $request->phone;
    
        if ($request->hasFile('photo')) {
            // Menghapus foto lama
            if ($admin->photo) {
                Storage::disk('public')->delete('photo-user/' . $admin->photo);
            }
    
            // Menyimpan foto baru
            $photo = $request->file('photo');
            $filename = date('Y-m-d') . '-' . $photo->getClientOriginalName();
            $path = 'photo-user/' . $filename;
    
            Storage::disk('public')->put($path, file_get_contents($photo));
            $admin->photo = $filename;
        }
        $admin->save();

        return back();
    }
    public function adminPass(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:4|confirmed',
        ]);
        
        $admin = Auth::guard('admin')->user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $admin ->password)) {
            $request->session()->flash('error', 'Password lama salah');
        }

        // Update the user's password
        $admin->password = Hash::make($request->password);
        $updated = $admin->save();
        if ($updated) {
            $request->session()->flash('success', 'Password berhasil diubah');
        }

        return back();
    }
    
}
