<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //Criar relacionamento entre as tabelas Fornecedor em Produtos, criando uma coluna produto_id na tabela Fornecedores
        Schema::table('produtos', function (Blueprint $table) {

            //insere um registro de fornecedor para estabelecer o relacionamento
            $fornecedor_id = DB::table('fornecedores')->insertGetId(
                [
                    'nome' => 'Fornecedor Padrão SG',
                    'site' => 'fornecedorpadraosg.com.br',
                    'uf' => 'SP',
                    'email' => 'contato@fornecedorpadraosg.com.br',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $table->unsignedBigInteger('fornecedor_id')->default($fornecedor_id)->after('id');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Criar o down desse relacionamento e coluna produto_id
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropForeign('produtos_fornecedor_id_foreign');
            $table->dropColumn('fornecedor_id');
        });
    }
};
