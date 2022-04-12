<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkuntansiDataBukuBantu extends Model
{
    use HasFactory;
    protected $table = 'akuntansi_data_buku_bantus';
    protected $fillable = [
        'piutang_usaha',
        'status',
        'saldo_awal',
        'debet',
        'kredit',
        'saldo_akhir'
    ];

    public function jurnal()
    {
        return $this->hasMany(AkuntansiJurnal::class, 'akuntansi_data_buku_bantu_id', 'id');
    }
}
