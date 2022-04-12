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
        Schema::create('akuntansi_data_buku_bantus', function (Blueprint $table) {
            $table->id();
            $table->string('piutang_usaha', 50);
            $table->string('status', 50);
            $table->float('saldo_awal');
            $table->float('debet');
            $table->float('kredit');
            $table->float('saldo_akhir');
            $table->timestamps();
        });

        Schema::create('finance_akuntansis_jurnal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('finance_akuntansis_data_id');
            $table->longText('ket_transaksi');
            $table->unsignedBigInteger('akun_lawan');
            $table->longText('ket_akun');
            $table->unsignedBigInteger('akuntansi_data_buku_bantu_id');
            $table->longText('ket_bantu');
            $table->timestamps();

            $table->foreign('finance_akuntansis_data_id')->references('id')->on('finance_akuntansis_data');
            $table->foreign('akun_lawan')->references('id')->on('finance_akuntansis_akun');
            $table->foreign('akuntansi_data_buku_bantu_id')->references('id')->on('akuntansi_data_buku_bantus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akuntansi_data_buku_bantus','finance_akuntansis_jurnal');
    }
};
