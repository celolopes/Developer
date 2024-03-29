<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteContatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Criar exemplos de contatos através de método de instancias
        /* $contato1 = new \App\Models\SiteContato();
        $contato1->nome = 'Sistema SG';
        $contato1->telefone = '(48) 9999-9999';
        $contato1->email = 'contato@sg.com.br';
        $contato1->motivo_contato = 1;
        $contato1->mensagem = 'Seja Bem vindo ao Site Super Gestão';
        $contato1->save(); */

        //Execute o método factory SiteContatoFactory
        \App\Models\SiteContato::factory(100)->create();
    }
}
