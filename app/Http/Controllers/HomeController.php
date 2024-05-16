<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $products = Product::Published()->Visible()->latest('published_at')->paginate(9);
        $categories = Category::Visible()->latest()->take(6)->get();

        return view('pages.home', compact('products', 'categories'));
    }
}
