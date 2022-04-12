<?php

namespace App\Http\Controllers\API\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repository\RepoExtend\Finance\AkuntansiJurnalRepository;

class AkuntansiJurnalController extends Controller
{
    protected $proses;
    function __construct(AkuntansiJurnalRepository $proses)
    {
        $this->proses = $proses;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $distinctNamaAkun = DB::select('SELECT DISTINCT id,nama FROM finance_akuntansis_akun');
        $dataRes = array();
        foreach ($distinctNamaAkun as $k => $v) {
            $sql = 'SELECT fad.*,faj.ket_transaksi, faj.akun_lawan, faj.ket_akun,faj.ket_bantu, adbb.piutang_usaha FROM finance_akuntansis_jurnal faj JOIN finance_akuntansis_data fad ON faj.finance_akuntansis_data_id=fad.id JOIN akuntansi_data_buku_bantus adbb ON faj.akuntansi_data_buku_bantu_id=adbb.id WHERE fad.akun_id = '.$v->id;
            $data = DB::select($sql);
            array_push($dataRes, array($v->nama => $data));
        }
        return response()->json(['response' => $dataRes], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // code
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
        $rules = $this->proses->form_validation('');
        $data = $this->proses->valid($input, $rules);
        if ($data['code'] == 200) {
            $data = $this->proses->store($input);
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
        $find = $this->proses->editEloquent($id);
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
