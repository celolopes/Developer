<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
    protected $table = 'modelos';
    protected $fillable = [
        'nome',
        'marca_id',
        'imagem',
        'numero_portas',
        'lugares',
        'air_bag',
        'abs'
    ];

    public function rules()
    {
        return [
            'nome' => 'required|unique:modelos,nome,' . $this->id . '|min:3',
            'marca_id' => 'exists:marcas,id',
            'imagem' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'numero_portas' => 'required|integer|digits_between:1,5',
            'lugares' => 'required|integer|digits_between:1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean'
        ];
    }

    public function feedback()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.min' => 'O campo nome deve conter no mínimo 3 caracteres',
            'nome.unique' => 'O campo nome já existe',
            'imagem.required' => 'O campo imagem é obrigatório',
            'imagem.image' => 'O campo imagem deve ser uma imagem',
            'imagem.mimes' => 'O campo imagem deve ser do tipo jpeg, png ou jpg',
            'imagem.max' => 'O campo imagem deve ter no máximo 2MB',
            'numero_portas.required' => 'O campo número de portas é obrigatório',
            'numero_portas.integer' => 'O campo número de portas deve ser um número inteiro',
            'numero_portas.digits_between' => 'O campo número de portas deve ter entre 1 e 5 dígitos',
            'lugares.required' => 'O campo número de lugares é obrigatório',
            'lugares.integer' => 'O campo número de lugares deve ser um número inteiro',
            'lugares.digits_between' => 'O campo número de lugares deve ter entre 1 e 20 dígitos',
            'air_bag.required' => 'O campo air bag é obrigatório',
            'air_bag.boolean' => 'O campo air bag deve ser verdadeiro ou falso',
            'abs.required' => 'O campo abs é obrigatório',
            'abs.boolean' => 'O campo abs deve ser verdadeiro ou falso'
        ];
    }

    public function marca()
    {
        return $this->belongsTo('App\Models\Marca');
    }
}
