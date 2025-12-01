<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceEmail;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders=Order::orderBy('id','DESC')->get();
        return view('dashboard.order.index', compact('orders'));
    }

    public function orderStatus(Request $request)
    {
        $order = Order::find($request->input('order_id'));

        if (!$order) {
            return back()->with('error', 'Pesanan tidak ditemukan');
        }

        $oldStatus = $order->status;

        $order->status = $request->input('status');
        $orderUpdated = $order->save(); 

        if ($orderUpdated && $request->input('status') === 'Batal' && $oldStatus !== 'Batal') {
            foreach ($order->products as $product) {
                $product->stock += $product->pivot->quantity;
                $product->save();
            }
    }

    if ($orderUpdated) {
        return back()->with('success', 'Pesanan berhasil diperbarui');
    } else {
        return back()->with('error', 'Pesanan gagal diperbarui');
    }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order=Order::find($id);
        if($order){
            return view('dashboard.order.show', compact('order'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        if ($order->delete()) {
            session()->flash('success', 'Pesanan berhasil dihapus');
        } else {
            session()->flash('error', 'Terjadi kesalahan saat menghapus pesanan');
        }

        return redirect()->route('order.index');
    }


    public function pay($id){
        $order = Order::findOrFail($id);
        
        if ($order->payment_status == 'Menunggu Pembayaran') {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => $order->total_amount,
                ],
                'customer_details' => [
                    'first_name' => $order->name,
                    'email' => $order->email,
                    'phone' => $order->phone,
                ],
                'item_details' => $order->products->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'price' => $item->price,
                        'quantity' => $item->pivot->quantity,
                        'name' => $item->title,
                    ];
                })->toArray(),
            ];

            $snapToken = Snap::getSnapToken($params);

            return view('shop.pages.payment', compact('snapToken', 'order'));
        }

        return redirect()->route('customer.order')->with('error', 'Pesanan tidak valid atau tidak dapat dibayar lagi.');
    }


    public function downloadPDF($id){
    $order = Order::find($id);

    if (!$order) {
        return back()->with('error', 'Pesanan tidak ditemukan');
    }

    $pdf = Pdf::loadView('dashboard.order.pdf', compact('order'));

    return $pdf->download('order_'.$order->order_number.'.pdf');
    }

    
    public function downloadReport()
    {
        $orders = Order::with('products')->orderBy('created_at', 'DESC')->get();
        $mostSoldProducts = $this->getMostSoldProducts();
        $monthlyIncome = $this->getMonthlyIncome();
        $totalOrdersThisMonth = $this->getTotalOrdersThisMonth();

        $pdf = PDF::loadView('dashboard.order.order_report', [
            'orders' => $orders,
            'mostSoldProducts' => $mostSoldProducts,
            'monthlyIncome' => $monthlyIncome,
            'totalOrdersThisMonth' => $totalOrdersThisMonth,
        ]);

        return $pdf->download('laporan_bulanan.pdf');
    }

    protected function getMostSoldProducts()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
    
        return Order::with('products')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->get()
            ->flatMap->products
            ->groupBy('id')
            ->map(function ($products) {
                return [
                    'name' => $products->first()->title,
                    'quantity' => $products->sum('pivot.quantity'),
                ];
            })
            ->sortByDesc('quantity')
            ->take(10);
    }


    protected function getMonthlyIncome()
    {
        return Order::where('status', 'Pesanan Diterima')
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');
    }


    protected function getTotalOrdersThisMonth()
    {
        return Order::whereMonth('created_at', now()->month)->count();
    }
    
    public function sendInvoiceByEmail($id)
    {
        $order = Order::findOrFail($id);
        $pdf = PDF::loadView('dashboard.order.pdf', compact('order'))->output();
    
        Mail::to($order->email)->send(new InvoiceEmail($order, $pdf));
    
        return redirect()->back()->with('success', 'Invoice berhasil dikirim ke email pengguna.');
    }


}
