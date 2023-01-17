<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\AbstractPaginator;

class Empresa extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Permite a definição de dados em massa
     * @var mixed
     */
    protected $fillable = ['tipo', 'nome', 'razao_social', 'documento', 'ie_rg', 'nome_contato', 'celular', 'email', 'telefone', 'cep', 'logradouro', 'bairro', 'cidade', 'estado', 'observacao'];

    /**
     * Define dados para serialização
     * @var array
     */
    protected $visible = ['id', 'text'];

    /**
     * Anexa acessores para serialização
     * @var array
     */
    protected $appends = ['text'];

    /**
     * Define a relação com estoque
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movimentosEstoque()
    {
        return $this->hasMany('App\Models\MovimentosEstoque');
    }

    /**
     * Retorna empresas por tipo
     * @param string $tipo
     * @param int $quantidade
     * @return AbstractPaginator
     */
    public static function todasPorTipo(string $tipo, string $busca, int $quantidade=10): AbstractPaginator
    {
        return self::where('tipo', $tipo)
            ->where(function ($q) use ($busca){
                $q->orWhere('nome', 'LIKE', "%$busca%")
                    ->orWhere('razao_social', 'LIKE', "%$busca%")
                    ->orWhere('nome_contato', 'LIKE', "%$busca%");
                    })
                    ->paginate($quantidade);
    }

    /**
     * Busca empresa por nome e tipo
     * @param string $nome
     * @param string $tipo
     * @return mixed
     */
    public static function buscarPorNomeTipo(string $nome, string $tipo)
    {
        $nome = '%' . $nome . '%';

        return self::where('nome', 'LIKE', $nome)
            ->where('tipo', $tipo)
            ->get();
    }

    /**
     * Cria acessor chamado text para serialização
     * @return string
     */
    public function getTextAttribute(): string
    {
        return sprintf(
            '%s (%s)',
            $this->attributes['nome'],
            $this->attributes['razao_social']
        );
    }

    /**
     * Buscas empresa por id e suas relações
     * @param mixed $id
     * @return Model|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|array<\Illuminate\Database\Eloquent\Builder>
     */
    public static function BuscarPorId($id)
    {
         return self::with([
            'movimentosEstoque' => function ($query) {
            $query->latest()->take(5);
            },
        'movimentosEstoque.produto' => function($q) {
            $q->withTrashed();
        }])
                            ->findOrFail($id);
    }
}
