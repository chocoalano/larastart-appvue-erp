<?php

namespace App\Repository\RepoExtend\Finance;

use App\Repository\AppBusinessProcessEloquent;
use App\Models\Finance\AkuntansiJurnal;

class AkuntansiJurnalRepository extends AppBusinessProcessEloquent
{
    protected $model;

    public function __construct(AkuntansiJurnal $model)
    {
        $this->model = $model;
    }

    public function fieldset()
    {
        return array(
            'finance_akuntansis_data_id',
            'ket_transaksi',
            'akun_lawan',
            'ket_akun',
            'akuntansi_data_buku_bantu_id',
            'ket_bantu'
        );
    }

    public function form_validation($id)
    {
        return array(
            'ket_transaksi' => 'required',
            'akun_lawan' => 'required',
            'ket_akun' => 'required',
            'akuntansi_data_buku_bantu_id' => 'required',
            'ket_bantu' => 'required',
        );
    }
}
