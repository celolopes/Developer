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
        //Criar coluna motivo_contatos_id
        Schema::table('site_contatos', function (Blueprint $table) {
            $table->unsignedBigInteger('motivo_contatos_id');
        });

        //Criando um DB::statement para mover os dados motivo_contato para motivo_contatos_id
        DB::statement('UPDATE site_contatos SET motivo_contatos_id = motivo_contato');

        //aplicar a fk em motivo_contatos_id apontando para coluna id da tabela motivo_contatos e por fim remover a coluna motivo_contato
        Schema::table('site_contatos', function (Blueprint $table) {
            $table->foreign('motivo_contatos_id')->references('id')->on('motivo_contatos');
            $table->dropColumn('motivo_contato');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Crie as reversões da função up da migration criando a coluna motivo_contato em site_contatos
        Schema::table('site_contatos', function (Blueprint $table) {
            $table->integer('motivo_contato');
            $table->dropForeign('site_contatos_motivo_contatos_id_foreign');
        });

        //Atribuir motivo_contatos_id para a coluna motivo_contato via DB::statement
        DB::statement('UPDATE site_contatos SET motivo_contato = motivo_contatos_id');

        //Remover a coluna motivo_contatos_id da tabela
        Schema::table('site_contatos', function (Blueprint $table) {
            $table->dropColumn('motivo_contatos_id');
        });
    }
};
