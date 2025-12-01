<?php

namespace App\Http\Controllers\Shop;

use Hash;
use App\Models\User;
use App\Models\Order;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Auth\Events\PasswordReset;

class IndexController extends Controller
{
    public function home(){
        $banners=Banner::where('status','aktif')->limit(3)->orderBy('id','DESC')->get();
        $product=Product::where('status','aktif')->limit(8)->orderBy('id','DESC')->get();
        return view('shop.index')->with('banners',$banners)->with('products',$product);
    }
    public function productCat(Request $request, $slug) {
        $category = Category::with(['products' => function($query) {$query->paginate(6);}])->where('slug', $slug)->first();
        $category_lists = Category::where('status', 'aktif')->withCount('products')->get();
        $sort = $request->sort ?? 'default';
    
        if ($category == null) {
            return view('error.404');
        } else {
            switch ($sort) {
                case 'priceAsc':
                    $products = Product::where(['status' => 'aktif', 'cat_id' => $category->id])->orderBy('price', 'ASC')->paginate(6);
                    break;
                case 'priceDesc':
                    $products = Product::where(['status' => 'aktif', 'cat_id' => $category->id])->orderBy('price', 'DESC')->paginate(6);
                    break;
                case 'conditionNew':
                    $products = Product::where(['status' => 'aktif', 'cat_id' => $category->id])->where('condition', 'baru')->paginate(6);
                    break;
                case 'conditionUsed':
                    $products = Product::where(['status' => 'aktif', 'cat_id' => $category->id])->where('condition', 'bekas')->paginate(6);
                    break;
                case 'titleAsc':
                    $products = Product::where(['status' => 'aktif', 'cat_id' => $category->id])->orderBy('title', 'ASC')->paginate(6);
                    break;
                case 'titleDesc':
                    $products = Product::where(['status' => 'aktif', 'cat_id' => $category->id])->orderBy('title', 'DESC')->paginate(6);
                    break;
                default:
                    $products = Product::where(['status' => 'aktif', 'cat_id' => $category->id])->paginate(6);
                    break;
            }
        }
        $route = 'product-cat';
        return view('shop.pages.product-cat', compact('category', 'category_lists', 'products', 'route', 'sort'));
    }
    public function productDetail($slug){
        $product = Product::where('slug', $slug)->first();
        if($product){
            return view('shop.pages.product-detail', compact('product'));
        }
    }

    public function userLogin(){
        if (Auth::check()) {
            return redirect()->route('home'); // Ubah sesuai dengan rute tujuan Anda
        }
        return view('shop.auth.login');
    }

    public function userRegister(){
        return view('shop.auth.register');
    }

    public function showForgotPasswordForm()
    {
        return view('shop.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm($token)
    {
        return view('shop.auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:4|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('user.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function userSubmitLog(Request $request){

        $messages = [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email ini belum terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus minimal 8 karakter.',
        ];

        $this->validate($request, [
            'email' => 'email|required|exists:users,email',
            'password' => 'required|min:8',
        ], $messages);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            Session::put('customer', $request->email);
    
            // Alihkan ke halaman home setelah login
            return redirect()->route('home')->with('success', 'Login berhasil. Selamat datang!');
        }
        else {
            return back()->with('error', 'Email atau kata sandi salah. Silakan coba lagi.');
        }
    }

    public function userSubmitReg (Request $request) {

        $messages = [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 50 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.string' => 'Nomor telepon wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi Password tidak cocok.',
        ];

        $this->validate($request, [
            'name' => 'string|required|max:50',
            'email' => 'email|required|unique:users,email', 
            'phone' => 'string|required',
            'password' => 'required|min:8|confirmed',
        ], $messages);

        $data = $request->all();

        $check = $this->create($data);
        if($check) {
            return redirect()->route('user.login')->with('success', 'Pendaftaran berhasil, silakan login.');
        }
        else {
            return back()->with('error', 'Pendaftaran gagal. Silakan coba lagi.');
        }
    }

    public function create (array $data) {
        return User::create([ 
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function userLogout(){
        Session::forget('user');
        Auth::logout();
        request()->session();
        return redirect()->route('home');
    }

    public function customerDashboard(){
        $user=Auth::user();
        
        return view('shop.user.dashboard', compact('user'));
    }

    public function customerOrder(){
        $user=Auth::user();

        $orders = $user->orders()->orderBy('created_at', 'DESC')->get();
        
        return view('shop.user.order', compact('user','orders'));
    }

    public function cancelOrder($id)
    {
        $order = Order::find($id);

        // Pastikan pesanan ada dan milik pengguna yang sedang login
        if ($order && $order->user_id === Auth::id()) {
            // Kembalikan stok produk
            foreach ($order->products as $product) {
                $product->stock += $product->pivot->quantity; // Mengasumsikan relasi many-to-many
                $product->save(); // Simpan perubahan stok
            }
        $order->status = 'Batal'; // Atur status menjadi 'Batal'
        $order->save();

            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Pesanan tidak ditemukan atau tidak dapat dibatalkan.');
    }

    public function confirmOrder($id)
    {
        $order = Order::find($id);

        // Pastikan pesanan ada dan milik pengguna yang sedang login
        if ($order && $order->user_id === Auth::id()) {
            $order->status = 'Pesanan Diterima'; // Atur status menjadi 'Diterima'
            $order->save();

            return redirect()->back()->with('success', 'Pesanan berhasil diterima.');
        }

        return redirect()->back()->with('error', 'Pesanan tidak ditemukan atau tidak dapat diterima.');
    }


    public function customerSetting(){
        $user=Auth::user();
        
        return view('shop.user.setting', compact('user'));
    }

    public function editProfile(Request $request, $id){
        $request->validate([
            'name' => 'string|required|max:30',
            'email' => 'string|required|unique:users,email,' . $id,
            'photo' => 'image|mimes:png,jpg,jpeg',
            'phone' => 'string|required',
            'address' => 'string|required',
        ]);

        $user=User::findOrFail($id);
    
        // Update user information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
    
        if ($request->hasFile('photo')) {
            // Menghapus foto lama
            if ($user->photo) {
                Storage::disk('public')->delete('photo-user/' . $user->photo);
            }
    
            // Menyimpan foto baru
            $photo = $request->file('photo');
            $filename = date('Y-m-d') . '-' . $photo->getClientOriginalName();
            $path = 'photo-user/' . $filename;
    
            Storage::disk('public')->put($path, file_get_contents($photo));
            $user->photo = $filename;
        }
        $user->save();

        return back();
        
    }

    public function changePass(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:4|confirmed',
        ]);
        
        $user = Auth::user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return redirect()->back()->with('error', 'Password lama tidak cocok');
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diubah');
    }

    public function productGrids(Request $request){
        $products=Product::where('status','aktif')->orderBy('id','DESC')->get();
        $sort = $request->sort ?? 'default';

        switch ($sort) {
            case 'priceAsc':
                $products = Product::where('status', 'aktif')->orderBy('price', 'ASC')->paginate(6);
                break;
            case 'priceDesc':
                $products = Product::where('status', 'aktif')->orderBy('price', 'DESC')->paginate(6);
                break;
            case 'conditionNew':
                $products = Product::where('status', 'aktif')->where('condition', 'baru')->paginate(6);
                break;
            case 'conditionUsed':
                $products = Product::where('status', 'aktif')->where('condition', 'bekas')->paginate(6);
                break;
            case 'titleAsc':
                $products = Product::where('status', 'aktif')->orderBy('title', 'ASC')->paginate(6);
                break;
            case 'titleDesc':
                $products = Product::where('status', 'aktif')->orderBy('title', 'DESC')->paginate(6);
                break;
            default:
                $products = Product::where('status', 'aktif')->paginate(6);
                break;
        }
    
        $route = 'products';
        return view('shop.pages.product')->with('products', $products)->with('sort', $sort)->with('route', $route);
    }

    public function search(Request $request) {
        $search = $request->query('search');
        $products = Product::with('brand')
            ->when($search, function($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('brand', function($query) use ($search) {
                        $query->where('title', 'like', '%' . $search . '%');
                    })
                    ->orWhere('description', 'like', '%' . $search . '%'); // Optional: Tambahkan pencarian di kolom lainnya jika perlu
            })
            ->paginate(10);

        return view('shop.pages.product-search', compact('products'));
    }
}
