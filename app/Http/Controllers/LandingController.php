<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // Cek apakah user sudah login
        if (Auth::check()) {
            // Cek apakah yang diakses adalah landing page
            if ($request->is('landing')) {
                // Tampilkan landing page jika sudah login
                return $this->showLandingPage($request);
            } else {
                // Redirect ke dashboard sesuai role
                if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Super Admin')) {
                    return redirect()->route('admin.dashboard');
                } elseif (Auth::user()->hasRole('Customer')) {
                    return redirect()->route('customer.dashboard');
                }
            }
        }

        // Ambil data untuk landing page
        return $this->showLandingPage($request);
    }

    private function showLandingPage(Request $request)
    {
        $search = $request->search;

        $products = Product::with('category', 'supplier')
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })->latest()->paginate(6);

        $categories = Category::with('products')->limit(12)->get();

        return view('landing.welcome', compact('products', 'categories', 'search'));
    }
}
