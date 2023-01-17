<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;

    /**
     * Define o nome da tabela
     * @var mixed
     */
    protected $table = 'saldo';

    /**
     * Define os dados que podem ser definidos em massa
     * @var mixed
     */
    protected $fillable = ['valor', 'empresa_id'];

    /**
     * Define relação com movimento de Estoque e Financeiro
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function movimento()
    {
        return $this->morphTo();
    }

    /**
     * Busca último saldo da empresa
     * @param mixed $empresaID
     * @return mixed
     */
    public static function ultimoPorEmpresa($empresaID)
    {
        return self::where('empresa_id', $empresaID)->latest()->first();
    }

    /**
     * Busca os saldos de uma empresa por intervalo
     * @param int $empresa
     * @param string $inicio
     * @param string $fim
     * @return mixed
     */
    public static function buscaPorIntervalo(int $empresa, string $inicio, string $fim)
    {
        return self::with('movimento')
                        ->whereBetween('created_at', [$inicio, $fim])
                        ->where('empresa_id', $empresa)
                        ->get();
    }
}
