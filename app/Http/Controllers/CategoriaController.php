<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        return response()->json(Categoria::orderBy('created_at', 'desc')->paginate(10));
    }

    // Retorna apenas os nomes das categorias com o id
    public function categorias()
    {
        return response()->json(Categoria::orderBy('nome', 'asc')->pluck('nome', 'id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|min:3|unique:categorias',
        ]);
        $categoria = (new Categoria)->fill($request->all());
        $categoria->save();
        return response()->json($categoria);
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nome' => 'required|min:3|unique:categorias',
        ]);
        $categoria->fill($request->all());
        $categoria->update();
        return response()->json($categoria);
    }

    // Faz uma busca pelo nome da categoria
    public function search(Request $request)
    {
        $categorias = Categoria::where("nome", "like", "%" . $request->s . "%")->paginate(10);
        return response()->json($categorias);
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
    }
}
