<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Cart;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{

    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function order(Request $request){
        // Validasi input customer
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'sub_total' => 'required|numeric',
            'total_amount' => 'required|numeric',
        ]);
    
        try {
            // Buat nomor pesanan unik
            $orderNumber = 'IPT-' . substr(md5(uniqid(rand(), true)), 0, 6);
    
            // Simpan data order ke database
            $order = new Order();
            $order->user_id = auth()->id();
            $order->order_number = $orderNumber;
            $order->name = $request->name;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->sub_total = $request->sub_total;
            $order->total_amount = $request->total_amount;
            $order->postcode = $request->postcode;
            $order->payment_status = 'Menunggu Pembayaran';
            $order->save();
    
            // Ambil produk dari cart
            $cartItems = Cart::where('user_id', auth()->id())->get();

             // Cek apakah keranjang kosong
            if ($cartItems->isEmpty()) {
                return redirect()->route('products')->with('error', 'Keranjang Anda kosong. Silakan tambahkan produk ke keranjang.');
            }
            
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    ProductOrder::create([
                        'product_id' => $item->product_id,
                        'order_id' => $order->id,
                        'quantity' => $item->quantity,
                    ]);
                    $product->stock -= $item->quantity;
                    $product->save();
                }
            }
    
            Cart::where('user_id', auth()->id())->delete();
    
            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;
            

            // Buat data transaksi untuk Midtrans
            $transaction_details = [
                'order_id' => $order->order_number,
                'gross_amount' => $order->total_amount, // Total pembayaran
            ];
    
            $customer_details = [
                'first_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ];
    
            $item_details = [];
            foreach ($cartItems as $item) {
                $item_details[] = [
                    'id' => $item->product_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'name' => $item->product->title,
                ];
            }
    
            $payload = [
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
                'item_details' => $item_details,
            ];
    
            // Buat Snap Token Midtrans
            $snapToken = Snap::getSnapToken($payload);
    
            return redirect()->route('order.confirmation', ['order' => $order->id]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat pesanan!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function confirmation(Order $order)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat data transaksi untuk Midtrans
        $transaction_details = [
            'order_id' => $order->order_number,
            'gross_amount' => $order->total_amount,
        ];

        $customer_details = [
            'first_name' => $order->name,
            'email' => $order->email,
            'phone' => $order->phone,
            'address' => $order->address,
        ];

        $item_details = [];
        foreach ($order->products as $item) {
            $item_details[] = [
                'id' => $item->product_id,
                'price' => $item->price,
                'quantity' => $item->pivot->quantity,
                'name' => $item->title,
            ];
        }

        $payload = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        ];

        // Buat Snap Token Midtrans
        $snapToken = Snap::getSnapToken($payload);

        return view('shop.pages.payment', compact('snapToken', 'order'));
    }


    public function callback(Request $request){
    
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
    
        if($hashed == $request->signature_key){
            if($request->transaction_status == 'settlement' || $request->transaction_status == 'capture'){
                $order = Order::where('order_number', $request->order_id)->first();
                if ($order) {
                    $order->update(['payment_status' => 'Lunas']);
                } elseif ($request->transaction_status == 'pending') {
                    $order->update(['payment_status' => 'Menunggu Pembayaran']);
                } elseif ($request->transaction_status == 'deny' || $request->transaction_status == 'expire' || $request->transaction_status == 'cancel') {
                    $order->update(['status' => 'Batal']);
                }
            }
        }
    }
}
