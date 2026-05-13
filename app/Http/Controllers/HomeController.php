<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $types = Type::orderBy('name')->get();

        $query = Product::with('type')
            ->where('quantity', '>', 0)
            ->where('price', '>', 0);

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }

        $products = $query->orderBy('name')->get();

        return view('welcome', compact('products', 'types'));
    }
}