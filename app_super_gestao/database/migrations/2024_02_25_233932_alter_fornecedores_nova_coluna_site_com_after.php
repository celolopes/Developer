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
        //criar nova coluna chamada site na tabela fornecedores com after da coluna nome
        Schema::table('fornecedores', function (Blueprint $table) {
            $table->string('site', 150)->after('nome')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //reverse de migrations
        Schema::table('fornecedores', function (Blueprint $table) {
            $table->dropColumn('site');
        });
    }
};
