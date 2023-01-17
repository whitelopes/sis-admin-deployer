@extends('layouts.app')

@section('title')
    <h1>Listagem de {{ $tipo }}</h1>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('empresas.index')}}?tipo={{ $tipo }}">Listagem de {{ $tipo }}</a>
</li>

@endsection


@section('content')
<div class="container fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listagem de {{ $tipo }}</h3>
                    <div class="card-tools">
                        <a href=" {{ route('empresas.create') }}?tipo={{ $tipo }}" class="btn btn-success">Novo {{ $tipo }}</a>
                    </div>
                </div>
                <div class="card-body">

                    <form method="GET" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                        <div class="input-group">
                            <input type="hidden" name="tipo" value="{{ $tipo }}">
                            <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>

                    <table class="table">
                        <thead>
                          <tr>
                            <th style="width: 10px">#</th>
                            <th>Nome Empresa</th>
                            <th>Nome Contato</th>
                            <th>Celular</th>
                            <th>Ações</th>
                          </tr>
                        </thead>
                        <tbody>
                         @forelse ($empresas as $empresa)
                            <tr>
                                <td>{{ $empresa->id }}</td>
                                <td>{{ $empresa->nome }}</td>
                                <td>{{ $empresa->nome_contato }}</td>
                                <td>{{ mascara($empresa->celular, '(##)#####-####') }} </td>
                                <td>
                                    <a href="{{ route('empresas.show', $empresa) }}" class="btn btn-primary">Detalhes</a>
                                    <a href="{{ route('empresas.edit', $empresa) }}" class="btn btn-info">Atualizar</a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Nenhum registro cadastrado</td>
                                <td></td>
                                <td></td>
                            </tr>
                         @endforelse
                        </tbody>
                      </table>
                </div>

                <div class="card-footer clearfix">
                    {{ $empresas->appends(['tipo'=> request('tipo') ])->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
