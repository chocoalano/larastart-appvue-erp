<?php

namespace App\Http\Controllers\API\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\RepoExtend\Finance\AkuntansiDataRepository;
use App\Repository\RepoExtend\Finance\AkuntansiAkunRepository;
use App\Repository\RepoExtend\Finance\AkuntansiBukuBantuRepository;
use App\Repository\RepoExtend\Finance\AkuntansiJurnalRepository;
use Illuminate\Support\Facades\DB;

class AkuntansiDataController extends Controller
{
    protected $proses;
    protected $akun;
    protected $bukubantu;
    protected $jurnal;
    function __construct(AkuntansiDataRepository $proses, AkuntansiAkunRepository $akun, AkuntansiBukuBantuRepository $bukubantu, AkuntansiJurnalRepository $jurnal)
    {
        $this->proses = $proses;
        $this->akun = $akun;
        $this->bukubantu = $bukubantu;
        $this->jurnal = $jurnal;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request()->search;
        $sortBy = request()->sortBy;
        $sortDesc = request()->sortDesc;
        $perpage = request()->itemsPerPage;
        $fieldsearch = $this->proses->fieldset();
        $data = $this->proses->paginated(
            $search,
            $sortBy,
            $sortDesc,
            $perpage,
            $fieldsearch,
        );
        return response()->json(['response' => $data['response']], $data['code']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $akun = $this->akun->getall();
        $buku_bantu = $this->bukubantu->getall();
        $pos_saldo = array('DEBET', 'KREDIT', '-');
        $group_laporan = array('NERACA', 'LABA RUGI');
        $group_arus_kas = array('OPERASIONAL', 'INVESTASI', 'PENDANAAN');
        $group_akun = array('AKTIVA LANCAR', 'AKTIVA TETAP', 'AKTIVA LAINNYA', 'KEWAJIBAN LANCAR', 'KEWAJIBAN JK PANJANG', 'EKUITAS', 'PENDAPATAN', 'HARGA POKOK PENJUALAN', 'BIAYA USAHA', 'PENDAPATAN & BIAYA LAINNYA');
        return response()->json(['response' => array('pos_saldo' => $pos_saldo, 'group_arus_kas' => $group_arus_kas, 'group_akun' => $group_akun, 'group_laporan' => $group_laporan, 'akun' => $akun['response'], 'buku_bantu' => $buku_bantu['response'])], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
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
        $rules = $this->proses->form_validation('');
        $data = $this->proses->valid($insertData, $rules);
        if ($data['code'] == 200) {
            $rulesjurnal = $this->jurnal->form_validation('');
            $datajurnal = $this->jurnal->valid($insertJurnal, $rulesjurnal);
            if ($datajurnal['code'] == 200) {
                $data = $this->proses->stored($input);
            }
        }

        return response()->json(['response' => $data['response']], $data['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $find = $this->proses->show($id);
        return response()->json(['response' => $find['response']], $find['code']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sql="select finance_akuntansis_data.*, finance_akuntansis_jurnal.ket_transaksi, finance_akuntansis_jurnal.akun_lawan, finance_akuntansis_jurnal.ket_akun,finance_akuntansis_jurnal.akuntansi_data_buku_bantu_id as kode_bantu, finance_akuntansis_jurnal.ket_bantu from `finance_akuntansis_data` inner join `finance_akuntansis_jurnal` on `finance_akuntansis_jurnal`.`finance_akuntansis_data_id` = `finance_akuntansis_data`.`id` where `finance_akuntansis_data`.`id` = ".$id;
        $find = $this->proses->editRawQuery($sql);
        return response()->json(['response' => $find['response']], $find['code']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $rules = $this->proses->form_validation('');
        $data = $this->proses->valid($input, $rules);
        if ($data['code'] == 200) {
            $data = $this->proses->update($id, $input);
        }
        return response()->json(['response' => $data['response']], $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->proses->delete($id);
        return response()->json(['response' => $data['response']], $data['code']);
    }
}
