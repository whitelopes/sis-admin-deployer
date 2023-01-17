<?php

namespace App\Http\Controllers;


use App\Models\MovimentosEstoque;
use App\Http\Requests\MovimentoEstoqueRequest;

class MovimentoEstoqueController extends Controller
{
    public function store(MovimentoEstoqueRequest $request)
    {
        MovimentosEstoque::create($request->all());

        return redirect()->back();
    }

    public function destroy(int $id)
    {
        MovimentosEstoque::destroy($id);

        return redirect()->back();
    }
}
