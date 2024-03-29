<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MotivoContato;

class MotivoContatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Criar o Run do Seeder de MotivoContatos
        MotivoContato::create([
            'motivo_contato' => 'Dúvida',
        ]);
        MotivoContato::create([
            'motivo_contato' => 'Elogio',
        ]);
        MotivoContato::create([
            'motivo_contato' => 'Reclamação',
        ]);
    }
}
