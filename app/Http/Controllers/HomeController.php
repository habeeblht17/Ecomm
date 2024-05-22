<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $sliders = Cache::rememberForever('sliders', function(){
            return Slider::Visible()->orderBy('serial', 'asc')->get();
        });

        $products = Product::Published()->Visible()->latest('published_at')->paginate(9);
        $categories = Category::Visible()->latest()->take(6)->get();
        //$sliders = Slider::Visible()->orderBy('serial', 'asc')->get();
        //dd($sliders);

        return view('pages.home', compact('products', 'categories', 'sliders'));
    }
}
