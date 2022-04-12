<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkuntansiData extends Model
{
    use HasFactory;
    protected $table = 'finance_akuntansis_data';
    protected $fillable = [
        'akun_id',
        'pos_saldo',
        'group_akun',
        'group_laporan',
        'saldo_awal_debet',
        'saldo_awal_kredit',
        'group_arus_kas'
    ];

    public function akun()
    {
        return $this->belongsTo(Akuntansi::class, 'id', 'akun_id');
    }
    public function jurnal()
    {
        return $this->hasOne(AkuntansiJurnal::class, 'finance_akuntansis_data_id', 'id');
    }
}
