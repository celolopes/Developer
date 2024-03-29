<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fornecedor;

class FornecedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Crie a run para Fornecedor
        $fornecedor = new Fornecedor();
        $fornecedor->nome = 'Fornecedor 100';
        $fornecedor->site = 'www.fornecedor100.com.br';
        $fornecedor->uf = 'MG';
        $fornecedor->email = 'contato@fornecedor100.com.br';
        $fornecedor->save();

        //Crie agora um create para fornecedor
        Fornecedor::create([
            //criar fornecedor ficticio
            'nome' => 'Fornecedor 200',
            'site' => 'www.fornecedor200.com.br',
            'uf' => 'MG',
            'email' => 'contato@fornecedor200.com.br'
        ]);

        //Crie através do insert
        Fornecedor::insert([
            'nome' => 'Fornecedor 300',
            'site' => 'www.fornecedor300.com.br',
            'uf' => 'PE',
            'email' => 'contato@fornecedor300.com.br'
        ]);
    }
}
