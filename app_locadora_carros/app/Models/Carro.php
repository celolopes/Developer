<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;
    protected $table = 'carros';
    protected $fillable = [
        'modelo_id',
        'placa',
        'disponivel',
        'km'
    ];

    public function rules()
    {
        return [
            'modelo_id' => 'required|exists:modelos,id',
            'placa' => 'required',
            'disponivel' => 'required|boolean',
            'km' => 'required|integer'
        ];
    }

    public function feedback()
    {
        return [
            'modelo_id.required' => 'O campo modelo é obrigatório',
            'modelo_id.exists' => 'O campo modelo não existe',
            'placa.required' => 'O campo placa é obrigatório',
            'placa.min' => 'O campo placa deve conter no mínimo 7 caracteres',
            'disponivel.required' => 'O campo disponivel é obrigatório',
            'disponivel.boolean' => 'O campo disponivel deve ser verdadeiro ou falso',
            'km.required' => 'O campo km é obrigatório',
            'km.integer' => 'O campo km deve ser um número inteiro'
        ];
    }

    public function modelo()
    {
        return $this->belongsTo('App\Models\Modelo');
    }

    public function locacoes()
    {
        return $this->hasMany('App\Models\Locacao');
    }
}
