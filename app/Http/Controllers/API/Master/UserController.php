<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\RepoExtend\UserRepository;

class UserController extends Controller
{
    protected $proses;
    function __construct(UserRepository $proses)
    {
        $this->proses = $proses;

        // $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        // $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:user-delete', ['only' => ['destroy']]);
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
        return response()->json(['response'=>$data['response']],$data['code']);
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
        return response()->json(['response'=>$data['response']],$data['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->proses->show($id);
        return response()->json(['response'=>$data['response']],$data['code']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sql="
        select u.name,
        u.email,
        u.id,
        r.name as rolename, 
        r.id as roleid 
        from users u join model_has_roles mhr 
        on u.id=mhr.model_id 
        join roles r 
        on r.id=mhr.role_id 
        where u.id=".$id;
        $data = $this->proses->editRawQuery($sql);
        return response()->json(['response'=>$data['response']],$data['code']);
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
        return response()->json(['response'=>$data['response']],$data['code']);
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
        return response()->json(['response'=>$data['response']],$data['code']);
    }
}
