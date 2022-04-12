<?php

namespace App\Repository\RepoExtend\Finance;

use App\Repository\AppBusinessProcessEloquent;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Finance\AkuntansiData;
use Illuminate\Support\Facades\DB;

class AkuntansiDataRepository extends AppBusinessProcessEloquent
{
    protected $model;

    public function __construct(AkuntansiData $model)
    {
        $this->model = $model;
    }

    public function fieldset()
    {
        return array(
            'akun_id',
            'pos_saldo',
            'group_akun',
            'group_laporan',
            'saldo_awal_debet',
            'saldo_awal_kredit',
            'group_arus_kas'
        );
    }

    public function form_validation($id)
    {
        return array(
            'akun_id' => 'required',
            'pos_saldo' => 'required|in:DEBET,KREDIT,-',
            'group_akun' => 'required|in:AKTIVA LANCAR,AKTIVA TETAP,AKTIVA LAINNYA,KEWAJIBAN LANCAR,KEWAJIBAN JK PANJANG,EKUITAS,PENDAPATAN,HARGA POKOK PENJUALAN,BIAYA USAHA, PENDAPATAN & BIAYA LAINNYA',
            'group_laporan' => 'required|in:NERACA,LABA RUGI',
            'saldo_awal_debet' => 'required|numeric',
            'saldo_awal_kredit' => 'required|numeric',
            'group_arus_kas' => 'required|in:OPERASIONAL,INVESTASI,PENDANAAN'
        );
    }

    public function stored($input){
        try {
            $insertData = [
                'akun_id' => $input['akun_id'],
                'pos_saldo' => $input['pos_saldo'],
                'group_akun' => $input['group_akun'],
                'saldo_awal_debet' => $input['saldo_awal_debet'],
                'saldo_awal_kredit' => $input['saldo_awal_kredit'],
                'group_arus_kas' => $input['group_arus_kas'],
                'group_laporan' => $input['group_laporan']
            ];
            $insertJurnal = [
                'ket_transaksi' => $input['ket_transaksi'],
                'akun_lawan' => $input['akun_lawan'],
                'ket_akun' => $input['ket_akun'],
                'akuntansi_data_buku_bantu_id' => $input['kode_bantu'],
                'ket_bantu' => $input['ket_bantu']
            ];
            $store = $this->model->create($insertData);
            $store->jurnal()->create($insertJurnal);
            $response['response'] = $input;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }
    public function jurnal($bulan, $tahun)
    {
        try {
            $q = DB::table('finance_akuntansis_akun')
            ->join('finance_akuntansis_data', 'finance_akuntansis_data.akun_id', '=', 'finance_akuntansis_akun.id')
            ->whereYear('finance_akuntansis_data.created_at', '=', $tahun)
            ->whereMonth('finance_akuntansis_data.created_at', '=', $bulan)
            ->get();
            $data=array();
            foreach ($q as $k => $v) {
                array_push($data,array(
                    'tanggal'=>date('d F Y', strtotime($v->created_at)),
                    'kas_akun'=>$v->id,
                    'ket_transaksi'=>$v->nama,
                    'akun_lawan'=>$v->id,
                    'ket_akun'=>$v->nama,
                    'kode_bantu'=>$v->id,
                    'ket_bantu'=>$v->id,
                    'debet'=>$v->saldo_awal_debet,
                    'kredit'=>$v->saldo_awal_kredit,
                    'saldo'=>$v->saldo_awal_kredit+$v->saldo_awal_debet,
                ));
            }
            $response['response'] = $data;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    public function paginated($search, $sortBy, $sortDesc, $perpage, $fieldsearch)
    {
        try {
            $sortby = ($sortBy == '') ? 'finance_akuntansis_data.created_at' : $sortBy;
            $sortdesc = ($sortDesc !== '' && $sortDesc == true) ? 'DESC' : 'ASC';
            $u =DB::table('finance_akuntansis_data')
            ->join('finance_akuntansis_akun', 'finance_akuntansis_akun.id', '=', 'finance_akuntansis_data.akun_id') 
            ->orderBy($sortby, $sortdesc)
            ->select('finance_akuntansis_data.*', 'finance_akuntansis_akun.nama');
            if ($search != '') {
                if (count($fieldsearch) > 1) {
                    for ($i = 0; $i < count($fieldsearch); $i++) {
                        $u = $u->orWhere($fieldsearch[$i], "like", "%" . $search . "%");
                    }
                } else {
                    $u = $u->where($fieldsearch[0], 'LIKE', '%' . $search . '%');
                }
            }
            $data = $u->paginate($perpage);
            $response['response'] = $data;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }
}
