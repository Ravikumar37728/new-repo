<?php

namespace App\Http\Controllers\Api_Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Http\Resources\CommonCollection;
use App\Http\Resources\ContactUsResource;
use App\Models\contactus;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Traits\MessagesTrait;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mockery\Matcher\Contains;

class ContactusApicontroller extends Controller
{
    use MessagesTrait;

    public function storecontactus(ContactUsRequest $request)
    {
       $store=  contactus::create($request->all());
       return (new ContactUsResource($store));
    }

    public function showcontactus($id = null,Request $request)
    {
        if(Auth::guard('api')->check())
        {
            if(isset($id))
            {if($id!= null){
                $request['id']=$id;
            }else{
                return $this->getMessage([], "product id required", config('constants.validation_codes.unauthorized'), false);

            }


            $rules = array(
                // 'name'  => "required|min:2|max:30|email",

                'id'=>"exists:contactus,id",

            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $validator->errors();
            }
                $data = db::table('contactus')->where('id',$id)->first();
                return (new ContactUsResource($data));
            }
            $showdata=contactus::paginate('10');

            return new CommonCollection(ContactUsResource::collection($showdata),ContactUsResource::class);

        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);


    }
}
