<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    public function vitrine(Request $request)
    {
    
        $types = Type::all();

        
        $query = Product::with('type')->where('quantity', '>', 0);

        
        if ($request->has('type_id') && $request->type_id != '') {
            $query->where('type_id', $request->type_id);
        }

        $products = $query->get();

       
        return view('welcome', compact('products', 'types'));
    }

    
    public function index()
    {
        return view('products.index', [
            'products' => Product::all()
        ]);
    }

    
    public function create()
    {
        return view('products.create', ['types' => Type::all()]);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'quantity' => 'required|gt:0',
            'price' => 'required|gt:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        try {
            Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'image' => $imagePath,
                'type_id' => $request->type_id
            ]);
            return redirect('/products')->with('success', 'Produto criado com sucesso');
        } catch(\Exception $e) {
            Log::error('Erro ao salvar produto', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Não foi possível salvar o produto.')->withInput();
        }
    }

   
    public function edit($id)
    {
        $product = Product::find($id);
        return view('products.edit', ['product' => $product, 'types' => Type::all()]);
    }

    
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'quantity' => 'required|gt:0',
            'price' => 'required|gt:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $product = Product::find($request->id);
        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'image' => $imagePath,
            'type_id' => $request->type_id
        ]);

        return redirect('/products')->with('success', 'Produto atualizado com sucesso!');
    }

    
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect('/products')->with('success', 'Produto excluído com sucesso!');
    }
}