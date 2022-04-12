<?php

namespace App\Repository\RepoExtend\Finance;

use App\Repository\AppBusinessProcessEloquent;
use App\Models\Finance\Akuntansi;

class AkuntansiAkunRepository extends AppBusinessProcessEloquent
{
    protected $model;

    public function __construct(Akuntansi $model)
    {
        $this->model = $model;
    }

    public function fieldset()
    {
        return array(
            'nama',
            'inisial'
        );
    }

    public function form_validation($id)
    {
        return array(
            'nama' => (!empty($id)) ? 'required|string|unique:finance_akuntansis_akun,nama,' . $id : 'required|string|unique:finance_akuntansis_akun,nama',
            'inisial' => 'required|in:KAS,PIUTANG,HUTANG,REKON,MEMO,AWAL,AKHIR'
        );
    }
}
