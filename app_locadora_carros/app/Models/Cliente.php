<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';

    protected $fillable = [
        'nome'
    ];
    public function rules()
    {
        return [
            'nome' => 'required|min:3'
        ];
    }

    public function feedback()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.min' => 'O campo nome deve conter no mínimo 3 caracteres'
        ];
    }

    public function locacoes()
    {
        return $this->hasMany('App\Models\Locacao');
    }
}
