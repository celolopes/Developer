<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{
    use HasFactory;
    protected $table = 'locacoes';

    protected $fillable = [
        'cliente_id',
        'carro_id',
        'data_inicio_periodo',
        'data_final_previsto_periodo',
        'data_final_realizado_periodo',
        'valor_diaria',
        'km_inicial',
        'km_final'
    ];

    public function rules()
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'carro_id' => 'required|exists:carros,id',
            'data_inicio_periodo' => 'required|date',
            'data_final_previsto_periodo' => 'required|date',
            'data_final_realizado_periodo' => 'nullable|date',
            'valor_diaria' => 'required|numeric',
            'km_inicial' => 'required|integer',
            'km_final' => 'nullable|integer'
        ];
    }

    public function feedback()
    {

        return [
            'cliente_id.required' => 'O campo cliente é obrigatório',
            'cliente_id.exists' => 'O campo cliente não existe',
            'carro_id.required' => 'O campo carro é obrigatório',
            'carro_id.exists' => 'O campo carro não existe',
            'data_inicio_periodo.required' => 'O campo data_inicio_periodo é obrigatório',
            'data_inicio_periodo.date' => 'O campo data_inicio_periodo deve ser uma data válida',
            'data_final_previsto_periodo.required' => 'O campo data_final_previsto_periodo é obrigatório',
            'data_final_previsto_periodo.date' => 'O campo data_final_previsto_periodo deve ser uma data válida',
            'data_final_realizado_periodo.date' => 'O campo data_final_realizado_periodo deve ser uma data válida',
            'valor_diaria.required' => 'O campo valor_diaria é obrigatório',
            'valor_diaria.numeric' => 'O campo valor_diaria deve ser um número',
            'km_inicial.required' => 'O campo km_inicial é obrigatório',
            'km_inicial.integer' => 'O campo km_inicial deve ser um número inteiro',
            'km_final.integer' => 'O campo km_final deve ser um número inteiro'
        ];
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente');
    }

    public function carro()
    {
        return $this->belongsTo('App\Models\Carro');
    }
}
