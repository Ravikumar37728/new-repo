<?php

namespace App\Http\Controllers\Api_Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\productrequest;
use App\Http\Requests\storeproductrequest;
use App\Http\Resources\store_product;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CommonCollection;
use Illuminate\Support\Str;
use App\Traits\MessagesTrait;



use Illuminate\Http\Request;

class productApicontroller extends Controller
{
    use  MessagesTrait;

    public  function store(storeproductrequest $request)
    {
        if (Auth::guard('api')->check()) {


            $product = new product;


            $product->name = $request->name;
            $product->short_desc = $request->short_desc;
            $product->desc = $request->desc;
            $product->price = $request->price;

            if ($request->image) {
                $file = $request->file('image');
                $imageName = Str::random(30);
                $destinationPath = "public/images/";
                $filename = $imageName . '' . '.' . $file->extension();
                Storage::putFileAs($destinationPath, $file, $filename);
                $product->product_image = $filename;
            }
            if ($request->video) {
                $file = $request->file('video');
                $videoName = Str::random(30);
                $destinationPath = "public/videos/";
                $filename = $videoName . '' . '.' . $file->extension();
                Storage::putFileAs($destinationPath, $file, $filename);
                $product->product_video = $filename;
            }
            $product->save();
            return (new store_product($product))->additional([
                'status' => true,
                'status_code' => config('constants.validation_codes.created'),
                'Message' => config('constants.messages.success.stored_success')
            ]);
            // return  ($request->all());
            // return $this->getMessage($request->all(), config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), true);
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }

    public function show($id = null, Request $request)
    {

        if (isset($id)) {
            if ($id != null) {
                $request['id'] = $id;
            } else {
                return $this->getMessage([], "product id required", config('constants.validation_codes.unauthorized'), false);
            }


            $rules = array(
                // 'name'  => "required|min:2|max:30|email",

                'id' => "exists:products,id",

            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $validator->errors();
            }


            $show = Product::find($id);
            return (new store_product($show))->additional([
                'status' => true,
                'status_code' => "200",
                'Message' => 'Data Listed Succesfully'
            ]);
        } else {
            $show = product::paginate('15');
            return  new CommonCollection(store_product::collection($show), store_product::class);
        }
    }

    public function deletedata($id, Request $request)
    {
        if (Auth::guard('api')->check()) {
            if ($id != null) {
                $request['id'] = $id;
            } else {
                return $this->getMessage([], "product id required", config('constants.validation_codes.unauthorized'), false);
            }


            $rules = array(
                // 'name'  => "required|min:2|max:30|email",

                'id' => "exists:products,id",

            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $validator->errors();
            }
            $delete = product::find($id)->delete();
            if ($delete) {
                return $this->getMessage($delete, config('constants.messages.success.deleted_success'), config('constants.validation_codes.ok'), true);
            }
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }

    public function updatedata($id, Request $request)
    {
        if (Auth::guard('api')->check()) {
            if ($id != null) {
                $request['id'] = $id;
            } else {
                return $this->getMessage([], "product id required", config('constants.validation_codes.unauthorized'), false);
            }



            $rules = array(
                'id' => 'required|exists:products,id',

                'price' => 'numeric'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $validator->errors();
            }
            $productdata = Product::find($id);
            if ($request->image) {
                $file = $request->file('image');
                $imageName = Str::random(30);
                $destinationPath = "public/images/";
                $filename = $imageName . '.' . $file->extension();
                Storage::putFileAs($destinationPath, $file, $filename);
                $productdata['product_image'] = $filename;
                $productdata->update();
            }
            if ($request->video) {
                $file = $request->file('video');
                $videoName = Str::random(30);
                $destinationPath = "public/videos/";
                $filename = $videoName . '.' . $file->extension();
                Storage::putFileAs($destinationPath, $file, $filename);
                $productdata['product_video'] = $filename;
                $productdata->update();
            }



            $productdata->update($request->all());

            if ($productdata) {
                return $this->getMessage($productdata, config('constants.messages.success.updated_success'), config('constants.validation_codes.ok'), true);
            }
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }

    public function list()
    {
        $list = product::all()->pluck('name');
        return $this->getMessage($list, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), true);
    }
}
