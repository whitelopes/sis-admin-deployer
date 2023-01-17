<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimentosEstoque extends Model
{
    use HasFactory;
    /**
     * Define o nome da tabela
     * @var mixed
     */
    protected $table = 'movimentos_estoque';

    /**
     * Campos permitidos em definição de dados em massa
     * @var array
     */
    protected $fillable = ['produto_id', 'valor', 'quantidade', 'tipo', 'empresa_id'];

    /**
     * Indica que o Movimento de estoque
     * sempre deve carregar a relação produto
     * @var mixed
     */
    protected $with = ['produto'];

    /**
     * Define a relação com produto
     * @return BelongsTo
     */
    public function produto()
    {
        return $this->BelongsTo('App\Models\Produto')->withTrashed();
    }

    /**
     * Configura a relação com histórico do saldo
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function saldo()
    {
        return $this->morphOne('App\Models\Saldo', 'movimento');
    }
}
