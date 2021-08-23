<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        return response()->json(Produto::with('categoria')->orderBy('created_at', 'desc')->paginate(10));
    }

    // Faz uma busca pelo nome ou o código do produto
    public function search(Request $request)
    {
        $produtos = Produto::with('categoria')
            ->orderBy('created_at', 'desc')
            ->where("nome", "like", "%" . $request->s . "%")
            ->orWhere("codigo", "like", "%" . $request->s . "%")
            ->paginate(10);
        return response()->json($produtos);
    }

    public function store(ProdutoRequest $request)
    {
        $produto = (new Produto)->fill($request->all());
        $produto->codigo = time();
        $produto->save();
        return response()->json($produto);
    }

    public function update(ProdutoRequest $request, Produto $produto)
    {
        $produto->fill($request->all());
        $produto->update();
        return response()->json($produto);
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
    }
}
