<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'imagem'
    ];

    public function rules()
    {
        return [
            'nome' => 'required|unique:marcas,nome,' . $this->id . '|min:3',
            'imagem' => 'required|image|mimes:jpeg,png,jpg|max:2048'
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
            'imagem.max' => 'O campo imagem deve ter no máximo 2MB'
        ];
    }

    public function modelos()
    {
        return $this->hasMany('App\Models\Modelo');
    }
}
