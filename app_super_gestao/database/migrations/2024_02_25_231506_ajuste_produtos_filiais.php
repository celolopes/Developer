<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //criando a tabela filiais
        Schema::create('filiais', function (Blueprint $table) {
            $table->id();
            $table->string('filial', 30);
            $table->timestamps();
        });

        //criando a tabela produto_filiais
        Schema::create('produto_filiais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('filial_id');
            $table->decimal('preco_venda', 8, 2);
            $table->integer('estoque_mininmo');
            $table->integer('estoque_maximo');
            $table->foreign('filial_id')->references('id')->on('filiais');
            $table->unsignedBigInteger('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');
        });

        //removendo as colunas preco_venda, estoque_minimo e estoque_maximo da tabela produtos
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('preco_venda');
            $table->dropColumn('estoque_minimo');
            $table->dropColumn('estoque_maximo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //adicionar colunas da tabela produtos
        Schema::table('produtos', function (Blueprint $table) {
            $table->decimal('preco_venda', 8, 2)->nullable();
            $table->integer('estoque_minimo')->nullable();
            $table->integer('estoque_maximo')->nullable();
        });

        //removendo a tabela produto_filiais e filiais
        Schema::dropIfExists('produto_filiais');
        Schema::dropIfExists('filiais');
    }
};
