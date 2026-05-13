<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type; // Importado para facilitar o uso

class TypesController extends Controller
{
    /**
     * Exibe o formulário para criar um novo tipo/categoria.
     */
    public function create()
    {
        return view('types.create'); // Retorna a view do formulário
    }

    /**
     * Recebe os dados do formulário e salva no banco de dados.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'name' => 'required|min:2|max:50'
        ]);

        // Criação do registro no banco
        Type::create([
            'name' => $request->name
        ]);

        // Redireciona para o dashboard com mensagem de sucesso
        return redirect('/dashboard')->with('success', 'Tipo cadastrado com sucesso!');
    }
}