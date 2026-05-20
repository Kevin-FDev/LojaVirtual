<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function vitrine(Request $request)
    {
        $types = Type::all();

        $query = Product::with('type')->where('quantity', '>', 0);

        if ($request->filled('type_id')) {
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
            'name'     => 'required|min:2|max:50',
            'quantity' => 'required|gt:0',
            'price'    => 'required|gt:0',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        try {
            Product::create([
                'name'        => $request->name,
                'description' => $request->description,
                'quantity'    => $request->quantity,
                'price'       => $request->price,
                'image'       => $imagePath,
                'type_id'     => $request->type_id
            ]);

            return redirect('/products')->with('success', 'Produto criado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao salvar produto', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Não foi possível salvar o produto.')->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', [
            'product' => $product,
            'types'   => Type::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|min:2|max:50',
            'quantity' => 'required|gt:0',
            'price'    => 'required|gt:0',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $product   = Product::findOrFail($id);
        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        try {
            $product->update([
                'name'        => $request->name,
                'description' => $request->description,
                'quantity'    => $request->quantity,
                'price'       => $request->price,
                'image'       => $imagePath,
                'type_id'     => $request->type_id
            ]);

            return redirect('/products')->with('success', 'Produto atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar produto', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Não foi possível atualizar o produto.')->withInput();
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect('/products')->with('success', 'Produto excluído com sucesso!');
    }

    public function report()
    {
        return view('products.report', [
            'types' => Type::orderBy('name')->get()
        ]);
    }

    public function reportPdf(Request $request)
    {
        $products = DB::table('products')
            ->join('types', 'products.type_id', '=', 'types.id')
            ->select(
                'products.id',
                'products.name',
                'products.description',
                'products.quantity',
                'products.price',
                'products.image',
                'products.type_id',
                'types.name as type_name',
                'products.created_at',
                'products.updated_at'
            )
            ->when($request->filled('name'), fn ($query) => $query->where('products.name', 'like', "%{$request->name}%"))
            ->when($request->filled('type_id'), fn ($query) => $query->where('products.type_id', $request->type_id))
            ->when($request->filled('min_quantity'), fn ($query) => $query->where('products.quantity', '>=', $request->min_quantity))
            ->when($request->filled('max_quantity'), fn ($query) => $query->where('products.quantity', '<=', $request->max_quantity))
            ->orderBy('products.name')
            ->get();

        return Pdf::loadView('products.report-pdf', compact('products'))
            ->download('relatorio-produtos.pdf');
    }
}