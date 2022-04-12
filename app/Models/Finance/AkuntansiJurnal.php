<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkuntansiJurnal extends Model
{
    use HasFactory;
    protected $table = 'finance_akuntansis_jurnal';
    protected $fillable = [
        'finance_akuntansis_data_id',
        'ket_transaksi',
        'akun_lawan',
        'ket_akun',
        'akuntansi_data_buku_bantu_id',
        'ket_bantu'
    ];

    public function data()
    {
        return $this->belongsTo(AkuntansiData::class, 'id', 'finance_akuntansis_data_id');
    }
    public function bantuan()
    {
        return $this->belongsTo(AkuntansiDataBukuBantu::class, 'id', 'akuntansi_data_buku_bantu_id');
    }
}
