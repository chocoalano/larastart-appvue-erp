<?php

namespace App\Repository\RepoExtend;

use App\Repository\AppBusinessProcessEloquent;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AuthRepository extends AppBusinessProcessEloquent
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function ValidateFormLogin()
    {
        return array(
            'email' => 'required|email',
            'password' => 'required',
        );
    }

    public function login($req)
    {
        if (Auth::attempt(['email' => $req['email'], 'password' => $req['password']])) {
            $user = Auth::user();
            $response['response'] = $user->createToken('nApp')->accessToken;
            $response['code'] = Response::HTTP_OK;
        } else {
            $response['response'] = 'UNAUTHORIZED';
            $response['code'] = Response::HTTP_UNAUTHORIZED;
        }
        return $response;
    }

    public function ValidateFormRegister()
    {
        return array(
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        );
    }

    public function register($req)
    {
        try {
            DB::beginTransaction();
            $input = $req;
            $input['password'] = bcrypt($input['password']);
            $user = $this->model->create($input);
            DB::commit();
            $response['response'] = $user->createToken('nApp')->accessToken;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            DB::rollback();
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    public function details()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if (request()->user()->can($permission->name)) {
                $permissions[] = $permission->name;
            }
        }
        $res['user'] = Auth::user();
        $res['permission'] = $permissions;
        $response['response'] = $res;
        $response['code'] = Response::HTTP_OK;
        return $response;
    }

    public function signout()
    {
        $response['response'] = 'UNAUTHORIZED';
        $response['code'] = Response::HTTP_UNAUTHORIZED;
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            $response['response'] = 'token has logout';
            $response['code'] = Response::HTTP_OK;
        }
        return $response;
    }
}
