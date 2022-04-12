<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\RepoExtend\AuthRepository;

class AuthController extends Controller
{
    public $proses;

    public function __construct(AuthRepository $proses)
    {
        $this->proses = $proses;
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $rules = $this->proses->ValidateFormLogin();
        $response = $this->proses->valid($input, $rules);
        if ($response['code'] == 200) {
            $response = $this->proses->login($input);
        }
        return response()->json(['response'=>$response['response']],$response['code']);
    }

    public function register(Request $request)
    {
        $input = $request->all();
        $rules = $this->proses->ValidateFormRegister();
        $response = $this->proses->valid($input, $rules);
        if ($response['code'] == 200) {
            $response = $this->proses->register($input);
        }
        return response()->json(['response'=>$response['response']],$response['code']);
    }

    public function auth()
    {
        $response = $this->proses->details();
        return response()->json(['response'=>$response['response']],$response['code']);
    }

    public function logout()
    {
        $response = $this->proses->signout();
        return response()->json(['response'=>$response['response']],$response['code']);
    }
}
