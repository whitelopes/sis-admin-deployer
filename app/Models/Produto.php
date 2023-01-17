<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;

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
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'produtos';

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
    protected $fillable = ['nome', 'descricao'];

    /**
     * Buscas produto por nome
     * @param string $nome
     * @return mixed
     */
    public static function buscarPorNome(string $nome)
    {
        $nome = '%' . $nome . '%';

        return self::where('nome', 'LIKE', $nome)->get();
    }

    /**
     * Cria acessor chamado text para serialização
     * @return string
     */
    public function getTextAttribute(): string
    {
        return $this->attributes['nome'];
    }
}
