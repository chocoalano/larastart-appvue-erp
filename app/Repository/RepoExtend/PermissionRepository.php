<?php

namespace App\Repository\RepoExtend;

use App\Repository\AppBusinessProcessEloquent;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PermissionRepository extends AppBusinessProcessEloquent
{
    protected $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    public function fieldset()
    {
        return array(
            'name',
            'guard_name',
            'created_at',
        );
    }

    public function form_validation($id)
    {
        return array(
            'name' => (!empty($id)) ? 'required|string|unique:permissions,name,' . $id : 'required|string|unique:permissions,name'
        );
    }
    public function updated($id,$input)
    {
        try {
            DB::beginTransaction();
            $find = $this->model->find($id);
            $parse = explode("-",$find->name);
            for ($i=0; $i < count($input); $i++) { 
                $q = $this->model->where('name', 'like', '%' . $parse[0] . '%');
                $count = $q->count();
                if ($count > 0) {
                    $q->update($input[$i]);
                }
            }
            DB::commit();
            $response['response'] = $input;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            DB::rollback();
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }
}
