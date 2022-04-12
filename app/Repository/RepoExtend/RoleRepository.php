<?php

namespace App\Repository\RepoExtend;

use App\Repository\AppBusinessProcessEloquent;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleRepository extends AppBusinessProcessEloquent
{
    protected $model;
    protected $permission;

    public function __construct(Role $model, Permission $permission)
    {
        $this->model = $model;
        $this->permission = $permission;
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
            'name' => (!empty($id)) ? 'required|string|unique:roles,name,' . $id : 'required|string|unique:roles,name',
            'permission' => 'required',
        );
    }

    public function stored($req)
    {
        try {
            DB::beginTransaction();
            $role = $this->model->create(['name' => $req['name']]);
            $role->syncPermissions($req['permission']);
            DB::commit();
            $response['response'] = $req;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            DB::rollback();
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    public function updated($id, $req)
    {
        try {
            DB::beginTransaction();
            $role = $this->model->find($id);
            $role->name = $req['name'];
            $role->save();
            $role->syncPermissions($req['permission']);;
            DB::commit();
            $response['response'] = $req;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            DB::rollback();
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    public function shows($id)
    {
        try {
            DB::beginTransaction();
            $role = $this->model->find($id);
            $rolePermissions = $this->permission->join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
                ->where("role_has_permissions.role_id", $id)
                ->get();

            $data = array($role, $rolePermissions);
            DB::commit();
            $response['response'] = $data;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            DB::rollback();
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    public function edited($id)
    {
        try {
            DB::beginTransaction();
            $permission = [];
            $role = $this->model->find($id);
            $rolePermissions = DB::table("role_has_permissions")->where("role_id", $id)->get();
            foreach ($rolePermissions as $key => $v) {
                array_push($permission, $v->permission_id);
            }
            
            $data = array($role, $permission);
            $response['response'] = $data;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            DB::rollback();
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }
}
