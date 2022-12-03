<?php

namespace App\Http\Controllers\Api_Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonCollection;
use App\Http\Resources\VacancyResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\vacancy;
use App\Traits\MessagesTrait;
use Illuminate\Support\Facades\Validator;

class vacancyApicontroller extends Controller
{
    use MessagesTrait;
    public function addvacancy(request $request)
    {
        if (Auth::guard('api')->check()) {
            $vacancy = new vacancy();
            $vacancy->position = $request->position;
            $vacancy->description = $request->description;
            $vacancy->vacancy = $request->vacancy;
            $vacancy->experience = $request->experience;
            $vacancy->save();
            return (new VacancyResource($vacancy));
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }

    public function showvacancy($type = null)
    {
        if ($type == "desc"  && !is_null($type)) {
            $results = vacancy::orderBy('id', 'desc')->paginate(15);
            return new CommonCollection(VacancyResource::collection($results),VacancyResource::class);
        }
        $data = vacancy::paginate(15);
        return new CommonCollection(VacancyResource::collection($data),VacancyResource::class);

        return $this->getMessage($data, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), true);
    }
    public function deletevacancy($id,Request $request)
    {
        if (Auth::guard('api')->check()) {
            if($id!= null){
                $request['id']=$id;
            }else{
                return $this->getMessage([], "product id required", config('constants.validation_codes.unauthorized'), false);

            }


            $rules = array(
                // 'name'  => "required|min:2|max:30|email",

                'id'=>"exists:vacancy,id",

            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $validator->errors();
            }
            $delete = vacancy::find($id)->delete();
            if ($delete) {
                return $this->getMessage($delete, config('constants.messages.success.deleted_success'), config('constants.validation_codes.ok'), true);
            }
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }

    public function updatevacancy($id, Request $request)
    {
        if (Auth::guard('api')->check()) {
            if($id!= null){
                $request['id']=$id;
            }else{
                return $this->getMessage([], "product id required", config('constants.validation_codes.unauthorized'), false);

            }


            $rules = array(
                // 'name'  => "required|min:2|max:30|email",

                'id'=>"exists:vacancy,id",

            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $validator->errors();
            }
            $updatedata = vacancy::find($id);

            $updatedata->update($request->all());

            if ($updatedata) {
                return $this->getMessage($updatedata, config('constants.messages.success.updated_success'), config('constants.validation_codes.ok'), false);
            }
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }
}
