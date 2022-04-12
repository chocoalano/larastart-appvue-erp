<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akuntansi extends Model
{
    use HasFactory;
    protected $table = 'finance_akuntansis_akun';
    protected $fillable = [
        'nama',
        'inisial'
    ];

    public function data()
    {
        return $this->hasMany(AkuntansiData::class, 'akun_id', 'id');
    }
}
