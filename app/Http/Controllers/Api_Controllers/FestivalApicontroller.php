<?php

namespace App\Http\Controllers\Api_Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreativeRequest;
use App\Http\Resources\CreativeResource;
use App\Models\Creative;
use App\Models\Festival;
use App\Traits\SspfTrait;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\CommonCollection;
use App\Http\Resources\FestivalResource;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Storage;
use App\Traits\MessagesTrait;
use Illuminate\Support\Facades\Validator;

class FestivalApicontroller extends Controller
{
    use  MessagesTrait;

    public function storefestival(Request $request)
    {

        if (Auth::guard('api')->check()) {

            $data = Festival::create($request->all());
            return $data;
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }
    public function readallfestival(Request $request)
    {
        $data = Festival::paginate('15');
        if ($request->search) {

            $value = $request->search;
            $gg = Festival::query()->where('name', 'LIKE', "%{$value}%")->paginate('5');

            if ($request->has('sort') && !is_null($request->sort) && $request->has('order_by') && !is_null($request->order_by) && $request->has('instock')) {
                $gg = Festival::query()->where('name', 'LIKE', "%{$value}%")->orderby($request->sort, $request->order_by)->paginate('5');

                return  new CommonCollection(FestivalResource::collection($gg), FestivalResource::class);
            }
            if ($request->has('sort') && !is_null($request->sort) && $request->has('order_by') && !is_null($request->order_by)) {
                $gg = Festival::query()->where('name', 'LIKE', "%{$value}%")->orderby($request->sort, $request->order_by)->paginate('5');

                return  new CommonCollection(FestivalResource::collection($gg), FestivalResource::class);
            }
            return  new CommonCollection(FestivalResource::collection($gg), FestivalResource::class);
        }
        if ($request->has('sort') && !is_null($request->sort) && $request->has('order_by') && !is_null($request->order_by)) {
            if ($request->has('sort') && !is_null($request->sort) && $request->has('order_by') && !is_null($request->order_by) && $request->has('instock')) {
                $sort = Festival::orderBY($request->sort, $request->order_by)->where('in_stock', '0')->paginate('5');
                return  new CommonCollection(FestivalResource::collection($sort), FestivalResource::class);
            }
            $sort = Festival::orderBY($request->sort, $request->order_by)->paginate('5');
            return  new CommonCollection(FestivalResource::collection($sort), FestivalResource::class);
        }
        return  new CommonCollection(FestivalResource::collection($data), FestivalResource::class);
    }

    public function showfestival($id,Request $request)
    { if($id!= null){
        $request['id']=$id;
    }else{
        return $this->getMessage([], "product id required", config('constants.validation_codes.unauthorized'), false);

    }


    $rules = array(
        // 'name'  => "required|min:2|max:30|email",

        'id'=>"exists:festivals,id",

    );
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return $validator->errors();
    }
        $data = Festival::find($id);
        return $data;
    }

    public function updatefestival($id, Request $request)
    {
        if (Auth::guard('api')->check()) {
            if($id!= null){
                $request['id']=$id;
            }else{
                return $this->getMessage([], "product id required", config('constants.validation_codes.unauthorized'), false);

            }


            $rules = array(
                // 'name'  => "required|min:2|max:30|email",

                'id'=>"exists:festivals,id",

            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $validator->errors();
            }
            $data = Festival::find($id);
            $data->update($request->all());
            return $data;
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }
    public function  deletefestival($id,Request $request)
    {
        if (Auth::guard('api')->check()) {
            if($id!= null){
                $request['id']=$id;
            }else{
                return $this->getMessage([], "product id required", config('constants.validation_codes.unauthorized'), false);

            }


            $rules = array(
                // 'name'  => "required|min:2|max:30|email",

                'id'=>"exists:festivals,id",

            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $validator->errors();
            }
            $data = Festival::find($id);
            $data->delete();
            return $data;
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }

    public function storecreative(CreativeRequest $request)
    {
        if (Auth::guard('api')->check()) {

            $data = Creative::create($request->all());
            if ($request->creative) {
                $file = $request->file('creative');
                $imageName = Str::random(30);
                $destinationPath = "public/creatives/";
                $filename = $imageName . '' . '.' . $file->extension();
                Storage::putFileAs($destinationPath, $file, $filename);
                $data->update(['creative' => $filename]);
            }
            return (new CreativeResource($data))->additional([
                'status' => true,
                'status_code' => config('constants.validation_codes.created'),
                'Message' => config('constants.messages.success.stored_success')
            ]);
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }

    public function readallcreatives(request $request)
    {
        $data = Creative::paginate('15');
        if ($request->search) {

            $value = $request->search;
            $gg = Creative::query()->where('name', 'LIKE', "%{$value}%")->paginate('5');

            if ($request->has('sort') && !is_null($request->sort) && $request->has('order_by') && !is_null($request->order_by) && $request->has('instock')) {
                $gg = Creative::query()->where('name', 'LIKE', "%{$value}%")->orderby($request->sort, $request->order_by)->paginate('5');

                return  new CommonCollection(CreativeResource::collection($gg), CreativeResource::class);
            }
            if ($request->has('sort') && !is_null($request->sort) && $request->has('order_by') && !is_null($request->order_by)) {
                $gg = Creative::query()->where('name', 'LIKE', "%{$value}%")->orderby($request->sort, $request->order_by)->paginate('5');

                return  new CommonCollection(CreativeResource::collection($gg), CreativeResource::class);
            }
            return  new CommonCollection(CreativeResource::collection($gg), CreativeResource::class);
        }
        if ($request->has('sort') && !is_null($request->sort) && $request->has('order_by') && !is_null($request->order_by)) {
            if ($request->has('sort') && !is_null($request->sort) && $request->has('order_by') && !is_null($request->order_by) && $request->has('instock')) {
                $sort = Creative::orderBY($request->sort, $request->order_by)->where('in_stock', '0')->paginate('5');
                return  new CommonCollection(CreativeResource::collection($sort), CreativeResource::class);
            }
            $sort = Creative::orderBY($request->sort, $request->order_by)->paginate('5');
            return  new CommonCollection(CreativeResource::collection($sort), CreativeResource::class);
        }


        return  new CommonCollection(CreativeResource::collection($data), CreativeResource::class);
    }

    public function showcreative($id,Request $request)
    {if($id!= null){
        $request['id']=$id;
    }else{
        return $this->getMessage([], "product id required", config('constants.validation_codes.unauthorized'), false);

    }


    $rules = array(
        // 'name'  => "required|min:2|max:30|email",

        'id'=>"exists:creatives,id",

    );
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return $validator->errors();
    }
        $data = Creative::find($id);
        if ($data) {
            return (new CreativeResource($data))->additional([
                'status' => true,
                'status_code' => config('constants.validation_codes.created'),
                'Message' => config('constants.messages.success.showed_success')
            ]);
        }
        return $this->getMessage([], config('constants.messages.errors.content_not_found'), config('constants.validation_codes.content_not_found'), true);
    }
    public function deletecreative($id,Request $request)
    {if($id!= null){
        $request['id']=$id;
    }else{
        return $this->getMessage([], "product id required", config('constants.validation_codes.unauthorized'), false);

    }


    $rules = array(
        // 'name'  => "required|min:2|max:30|email",

        'id'=>"exists:creatives,id",

    );
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return $validator->errors();
    }
        if (Auth::guard('api')->check()) {
            $data = creative::find($id);
            if ($data) {
                $data->delete();
                return $this->getMessage([], config('constants.messages.success.deleted_success'), config('constants.validation_codes.ok'), true);
            }
            return $this->getMessage([], config('constants.messages.errors.content_not_found'), config('constants.validation_codes.content_not_found'), true);
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }
    public function updatecreative($id, request $request)
    {
        if($id!= null){
            $request['id']=$id;
        }else{
            return $this->getMessage([], "product id required", config('constants.validation_codes.unauthorized'), false);

        }


        $rules = array(
            // 'name'  => "required|min:2|max:30|email",

            'id'=>"exists:creatives,id",

        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }
        if (Auth::guard('api')->check()) {
            $data = creative::find($id);
            if ($data) {
                $data->update($request->all());
                if ($request->creative) {
                    $file = $request->file('creative');
                    $realpath = 'public/creatives/' . $data['creative'];
                    storage::delete($realpath);
                    $imageName = Str::random(30);
                    $destinationPath = "public/creatives/";
                    $filename = $imageName . '.' . $file->extension();
                    Storage::putFileAs($destinationPath, $file, $filename);
                    $photo['product_image'] = $filename;
                    $data->update(['creative' => $photo['product_image']]);
                }
                return (new CreativeResource($data))->additional([
                    'status' => true,
                    'status_code' => config('constants.validation_codes.created'),
                    'Message' => config('constants.messages.success.updated_success')
                ]);
            }
            return $this->getMessage([], config('constants.messages.errors.content_not_found'), config('constants.validation_codes.content_not_found'), true);
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }
}
