<?php

namespace App\Repository\RepoExtend\Finance;

use App\Repository\AppBusinessProcessEloquent;
use App\Models\Finance\AkuntansiDataBukuBantu;

class AkuntansiBukuBantuRepository extends AppBusinessProcessEloquent
{
    protected $model;

    public function __construct(AkuntansiDataBukuBantu $model)
    {
        $this->model = $model;
    }

    public function fieldset()
    {
        return array(
            'piutang_usaha',
            'status',
            'saldo_awal',
            'debet',
            'kredit',
            'saldo_akhir'
        );
    }

    public function form_validation($id)
    {
        return array(
            'piutang_usaha' => (!empty($id)) ? 'required|string|unique:akuntansi_data_buku_bantus,piutang_usaha,' . $id : 'required|string|unique:akuntansi_data_buku_bantus,piutang_usaha',
            'status' => 'required',
            'saldo_awal' => 'required|numeric',
            'debet' => 'required|numeric',
            'kredit' => 'required|numeric',
            'saldo_akhir' => 'required|numeric',
        );
    }
}
