<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class AppBusinessProcessEloquent
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    /**
     * get data with paginate all function.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getall()
    {
        try {
            $data = $this->model->all();
            $response['response'] = $data;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    /**
     * get data with paginate all function.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paginate($search, $sortBy, $sortDesc, $perpage, $fieldsearch)
    {
        try {
            $sortby = ($sortBy == '') ? 'created_at' : $sortBy;
            $sortdesc = ($sortDesc !== '' && $sortDesc == true) ? 'DESC' : 'ASC';
            $u = $this->model->orderBy($sortby, $sortdesc);
            if ($search != '') {
                if (count($fieldsearch) > 1) {
                    for ($i = 0; $i < count($fieldsearch); $i++) {
                        $u = $u->orWhere($fieldsearch[$i], "like", "%" . $search . "%");
                    }
                } else {
                    $u = $u->where($fieldsearch[0], 'LIKE', '%' . $search . '%');
                }
            }
            $data = $u->paginate($perpage);
            $response['response'] = $data;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    /**
     * store data process
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store($attributes)
    {
        try {
            DB::beginTransaction();
            $this->model->create($attributes);
            DB::commit();
            $response['response'] = $attributes;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            DB::rollback();
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    /**
     * store batch data process
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeBatch($attributes)
    {
        try {
            DB::beginTransaction();
            $this->model->insert($attributes);
            DB::commit();
            $response['response'] = $attributes;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            DB::rollback();
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    /**
     * show data process
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $response['response'] = $this->model->findOrFail($id);
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    /**
     * edit data process eloquent
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editEloquent($id)
    {
        try {
            $response['response'] = $this->model->findOrFail($id);
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    /**
     * edit data process with raw query
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editRawQuery($sql)
    {
        try {
            $response['response'] = DB::select($sql);
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    /**
     * update data process
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, $attributes)
    {
        try {
            DB::beginTransaction();
            $this->model->findOrFail($id)->update($attributes);
            DB::commit();
            $response['response'] = $attributes;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            DB::rollback();
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    /**
     * delete data process
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->model->destroy($id);
            DB::commit();
            $response['response'] = $id;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            DB::rollback();
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    /**
     * upload file data process
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadFile($img, $folderName)
    {
        try {
            $extension = $img->getClientOriginalExtension();
            $fileNameToStore = time() . '.' . $extension;
            $img->storeAs('public/' . $folderName, $fileNameToStore);
            $response['response'] = $fileNameToStore;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    /**
     * unlink file data process
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unlinkFile($img, $folderName)
    {
        try {
            if (Storage::exists('public/' . $folderName . '/' . $img)) {
                Storage::delete('public/' . $folderName . '/' . $img);
            }
            $response['response'] = $img;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    /**
     * validator data process
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function valid($req, $rules)
    {
        $validator = Validator::make($req, $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->errors();
            $response['code'] = Response::HTTP_UNPROCESSABLE_ENTITY;
        } else {
            $response['response'] = '';
            $response['code'] = Response::HTTP_OK;
        }
        return $response;
    }
}
