<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpresaRequest;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Saldo;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class EmpresaController extends Controller
{

    /**
     * Mostra a lista de cliente/fornecedor
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $tipo = $request->tipo;
        $this->validaTipo($tipo);

        $busca = $request->search ?? '';

        $empresas = Empresa::todasPorTipo($tipo, $busca);

        return view('empresa.index', compact('empresas', 'tipo'));
    }

    /**
     * Mostra o formulário para criação de um cliente/fornecedor
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $this->validaTipo($request->tipo);

        return view('empresa.create', [
            'tipo' => $request->tipo
        ]);
    }

    /**
     * Cria um novo cliente/fornecedor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpresaRequest $request): Response
    {
        $empresa = Empresa::create($request->all());

        return redirect()->route('empresas.show', $empresa->id);
    }

    /**
     * Mostra o cliente/fornecedor escolhido
     * @param Empresa $empresa
     * @return View
     */
    public function show(int $id): View
    {
        return view('empresa.show', [
            'empresa' => Empresa::BuscarPorId($id),
            'saldo' => Saldo::ultimoPorEmpresa($id)
        ]);
    }

    /**
     * Mostra o formulário para edição do cliente/fornecedor
     * @param Empresa $empresa
     * @return View
     */
    public function edit(Empresa $empresa): View
    {
        return view('empresa.edit', compact('empresa'));
    }

    /**
     * Atualiza os registros do cliente/fornecedor
     * @param EmpresaRequest $request
     * @param Empresa $empresa
     * @return Response
     */
    public function update(EmpresaRequest $request, Empresa $empresa): Response
    {
        $empresa->update($request->all());

        return redirect()->route('empresas.show', $empresa);
    }

    /**
     * Faz o softDelete do cliente/fornecedor
     * @param Request $request
     * @param Empresa $empresa
     * @return Response
     */
    public function destroy(Request $request, Empresa $empresa): Response
    {
        $this->validaTipo($request->tipo);

        $empresa->delete();

        return redirect()->route('empresas.index', ['tipo'=>$request->tipo]);
    }

    /**
     * Verifica se é cliente ou fornecedor
     * @param string $tipo
     * @return void
     */
    private function validaTipo(string $tipo)
    {
        if ($tipo !== 'cliente' && $tipo !== 'fornecedor') {
            abort(404);
        }
    }
}
