<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\RepoExtend\PermissionRepository;

class PermissionController extends Controller
{
    protected $proses;
    function __construct(PermissionRepository $proses)
    {
        $this->proses = $proses;

        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
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
        $perpage = request()->perpage;
        $fieldsearch = $this->proses->fieldset();
        $data = $this->proses->paginate(
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
        //
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
        $datainput = array();
        $error = array();
        $rules = $this->proses->form_validation('');
        for ($i = 0; $i < count($input['permission']); $i++) {
            $datafield = [
                'name' => $input['name'] . '-' . $input['permission'][$i],
                'guard_name' => 'api',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $data = $this->proses->valid($datafield, $rules);
            if ($data['code'] == 200) {
                array_push($datainput, $datafield);
            } else {
                array_push($error, $data);
            }
        }
        $data = $this->proses->storeBatch($datainput);
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
        $datainput = array();
        for ($i = 0; $i < count($input['permission']); $i++) {
            $datafield = [
                'name' => $input['name'] . '-' . $input['permission'][$i],
                'guard_name' => 'api',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            array_push($datainput, $datafield);
        }
        $data = $this->proses->updated($id, $datainput);
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
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getpermissionitem()
    {
        $search = request()->search;
        $sortBy = request()->sortBy;
        $sortDesc = request()->sortDesc;
        $perpage = request()->itemsPerPage;
        $fieldsearch = $this->proses->fieldset();
        $data = $this->proses->paginate(
            $search,
            $sortBy,
            $sortDesc,
            $perpage,
            $fieldsearch,
        );
        return response()->json(['response' => $data['response']], $data['code']);
    }
}
