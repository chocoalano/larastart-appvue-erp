<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_akuntansis_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('akun_id');
            $table->string('pos_saldo', 50);
            $table->string('group_akun', 50);
            $table->string('group_laporan', 50);
            $table->float('saldo_awal_debet');
            $table->float('saldo_awal_kredit');
            $table->string('group_arus_kas', 50);
            $table->timestamps();

            $table->foreign('akun_id')->references('id')->on('finance_akuntansis_akun');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_akuntansis_data');
    }
};
