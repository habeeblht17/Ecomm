<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('Products.detail', compact('product'));
    }
}
