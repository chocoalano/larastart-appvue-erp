<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\RepoExtend\RoleRepository;

class RoleController extends Controller
{
    protected $proses;
    function __construct(RoleRepository $proses)
    {
        $this->proses = $proses;

        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
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
        $rules = $this->proses->form_validation('');
        $data = $this->proses->valid($input, $rules);
        if ($data['code'] == 200) {
            $data = $this->proses->stored($input);
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
        $data = $this->proses->shows($id);
        return response()->json(['response' => $data['response']], $data['code']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->proses->edited($id);
        return response()->json(['response' => $data['response']], $data['code']);
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
        $rules = $this->proses->form_validation($id);
        $data = $this->proses->valid($input, $rules);
        if ($data['code'] == 200) {
            $data = $this->proses->updated($id, $input);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getrolesitem()
    {
        $data = $this->proses->getall();
        return response()->json(['response'=>$data['response']],$data['code']);
    }
}
