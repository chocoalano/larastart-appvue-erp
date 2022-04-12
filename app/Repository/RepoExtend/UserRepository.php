<?php

namespace App\Repository\RepoExtend;

use App\Repository\AppBusinessProcessEloquent;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserRepository extends AppBusinessProcessEloquent
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function fieldset()
    {
        return array(
            'name',
            'email',
            'created_at',
        );
    }

    public function form_validation($id)
    {
        return array(
            'name' => (!empty($id)) ? 'required|string|unique:users,name,' . $id : 'required|string|unique:users,name',
            'email' => (!empty($id)) ? 'required|email|unique:users,email,' . $id : 'required|email|unique:users,email',
            'password' => (!empty($id)) ?'':'required|min:8|same:c_password',
            'roles' => 'required|numeric'
        );
    }
    public function stored($req)
    {
        try {
            DB::beginTransaction();
            $req['password'] = Hash::make($req['password']);
            $user = $this->model->create($req);
            $user->assignRole($req['roles']);
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
            $req['password'] = Hash::make($req['password']);
            $user = $this->model->findOrFail($id);
            $user->update($req);
            $user->assignRole($req['roles']);
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
}
