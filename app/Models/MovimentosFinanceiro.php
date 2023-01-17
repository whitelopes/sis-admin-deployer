<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimentosFinanceiro extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'movimentos_financeiros';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['descricao', 'valor', 'tipo', 'empresa_id'];

    /**
     * Metódo responsável pela relação com a empresa
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    /**
     * Metódo responsável pela relação com o saldo
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function saldo()
    {
        return $this->morphOne('App\Models\Saldo', 'movimento');
    }

    /**
     * Busca movimentos por intervalo de data
     * @param string $inicio
     * @param string $fim
     * @param int $quantidade
     * @return mixed
     */
    public static function buscaPorIntervalo(string $inicio, string $fim, int $quantidade = 20)
    {
        return self::whereBetween('created_at', [$inicio, $fim])
                        ->with(['empresa' => function($q){
                            $q->withTrashed();
                        }])
                        ->paginate($quantidade);
    }

    /**
     * Busca movimento por id e tras a empresa mesmo que excluida
     * @param mixed $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static|static[]
     */
    public static function porIdComEmpresaExcluida($id)
    {
        return self::with(['empresa' => function($q) {
                    $q->withTrashed();
                }])
                ->findOrFail($id);
    }
}
