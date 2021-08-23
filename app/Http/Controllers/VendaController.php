<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Produto;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function index()
    {
        return response()->json(Venda::with('produto')->orderBy('created_at', 'desc')->paginate(10));
    }

    public function vendasDiarias()
    {
        $vendas = Venda::select(
            Venda::raw('DATE(created_at) as date'),
            Venda::raw('COUNT(*) as total'),
        )->groupBy('date')->get();

        $data = [['Dia', 'Vendas']];
        foreach ($vendas->toArray() as $key => $value) {
            $value['date'] = date('d/m', strtotime($value['date']));
            $value['total'] = (int) $value['total'];
            $data[] = array_values($value);
            if ($key >= 30) break;
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'produto_id' => 'exists:produtos,id',
            'quantidade' => 'required|numeric|min:0',
            'valor_total' => 'required|numeric',
            'forma_pagamento' => 'required',
            'status' => 'required|boolean'
        ]);

        $venda = (new Venda)->fill($request->all());
        $venda->save();

        $produto = Produto::find($request->produto_id);
        $qtdProd = $produto->quantidade - $request->quantidade;
        $produto->quantidade = $qtdProd < 0 ? 0 : $qtdProd;
        $produto->update();

        return response()->json($venda);
    }

    // Faz uma busca pelo nome do produto ou do cliente
    public function search(Request $request)
    {
        $vendas = Venda::with('produto')
            ->orderBy('created_at', 'desc')
            ->whereHas('produto', function ($q) {
                $q->where("nome", "like", "%" . $_GET['s'] . "%");
            })
            ->orWhere("cliente", "like", "%" . $request->s . "%")
            ->paginate(10);

        return response()->json($vendas);
    }

    public function destroy(Venda $venda)
    {
        $venda->delete();
    }
}
