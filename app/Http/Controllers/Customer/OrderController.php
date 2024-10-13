<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use App\Models\Product;
use App\Traits\HasImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Pastikan ini di sini
use App\Enums\OrderStatus;

class OrderController extends Controller
{
    use HasImage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil semua order milik user yang sedang login
        $orders = Order::with('user', 'product') // Mengambil relasi product juga
                       ->where('user_id', Auth::id())
                       ->paginate(10);
    
        // Ambil semua produk yang telah ditambahkan admin (untuk dropdown pilihan)
        $products = Product::all();
    
        // Kirim data order dan product ke view
        return view('customer.order.index', compact('orders', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Ambil data produk untuk ditampilkan pada dropdown di form
        $products = Product::all();
        return view('customer.order.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'unit' => 'required|in:pcs,pack',
        ]);
    
        // Ambil produk berdasarkan ID
        $product = Product::findOrFail($request->product_id);
    
        // Buat pesanan baru
        $order = new Order();
        $order->user_id = auth()->id(); // Ambil ID pengguna yang sedang login
        $order->product_id = $product->id; // Ambil ID produk
        $order->name = $product->name; // Gunakan nama produk
        $order->quantity = $request->quantity; // Jumlah yang diminta
        $order->unit = $request->unit; // Unit
        $order->status = OrderStatus::Pending; // Status awal
        $order->confirmation_code = Str::random(10); // Menghasilkan kode konfirmasi acak
        $order->save();
    
        // Redirect atau flash message setelah menyimpan
        return redirect()->route('customer.order.index')->with('success', 'Permintaan barang berhasil ditambahkan.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'unit' => 'required|in:pcs,pack',
        ]);

        $order->update([
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'unit' => $validated['unit'],
        ]);

        return back()->with('toast_success', 'Permintaan Barang Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('toast_success', 'Permintaan Barang Berhasil Dihapus');
    }
}
