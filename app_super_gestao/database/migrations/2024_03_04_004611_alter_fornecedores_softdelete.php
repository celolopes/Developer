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
        //Incluir a coluna SoftDeletes na tabela fornecedores
        Schema::table('fornecedores', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Criar a reversão da coluna SoftDeletes na tabela
        Schema::table('fornecedores', function (Blueprint $table) {
            //$table->dropColumn('deleted_at');
            $table->dropSoftDeletes();
        });
    }
};
