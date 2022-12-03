<?php

namespace App\Http\Controllers\Api_Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coupen;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Requests\coupenrequest;
use App\Http\Resources\coupen as ResourcesCoupen;
use App\Traits\MessagesTrait;
use Carbon\Carbon;
use Hamcrest\Core\HasToString;
use Illuminate\Support\Facades\DB;
// use Illuminate\support\Facades\DB;
use Illuminate\Contracts\Validation\Validator;


class coupanApicontroller extends Controller
{
    use MessagesTrait;
    public function create(coupenrequest $request)
    {
        if (Auth::guard('api')->check()) {


            // get the code of particular product id
            $check = DB::table("coupens")->where(['code' => $request->code, 'product' => $request->product])->get('code');

            if ($check->count() > 0)  // Check Code exist or not
            {
                return $this->getmessage([], 'your code is exist Kindly Add Another Code', '404', true);
            }
            $coupen = new Coupen();
            $coupen->code = $request->code;
            $coupen->price = $request->price;
            $coupen->product = $request->product;
            $coupen->duration = $request->duration;
            $coupen->save();

            return $this->getmessage($coupen, 'Coupen Add Succesfully', '200', true);
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }

    public function Coupencheck($id = null, Request $request)
    {
        if ($id != null) {
            $request['id'] = $id;
        }

        $code = $request->code;
        $rules = array(
            // 'name'  => "required|min:2|max:30|email",
            'code' => "required|exists:coupens,code",
            'id' => "exists:products,id"
        );
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $codecheck = DB::table("coupens")->where('code', $request->code)->first();

        if (Carbon::parse($codecheck->updated_at)->adddays($codecheck->duration) < Carbon::now()) {
            return $this->getMessage([], "Coupen code has been expired", 404, true);
        }

        $product_name = DB::table("products")->where('id', $request->id)->first('name');
        $name = $product_name->name;
        $check = DB::table("coupens")->where(['product' => $name, 'code' => $request->code])->get('price');
        if ($check->count() <= 0) {
            $product = DB::table('products')->where('id', $request->id)->first("price")->price;
            $cgst = $product * 9 / 100;
            $sgst = $product * 9 / 100;

            $sub_total = $product + $cgst + $sgst;
            $discount = 0;
            $final_amount =  $sub_total - $discount;
            $data = array(
                'price' => $product,
                'cgst' => $cgst,
                'sgst' => $sgst,
                'subtotal' => $sub_total,
                'discount' => $discount,
                'final_amount' => $final_amount,
            );
            return $this->getMessage($data, "Coupen Applied Succesfully", 200, true);
        }
        $product = DB::table('products')->where('id', $request->id)->first("price")->price;
        $checked = DB::table("coupens")->where(['product' => $name, 'code' => $request->code])->first('price')->price;

        // Make calculation of the bill
        $product_amount = $product - $checked;
        $cgst = $product_amount * 9 / 100;
        $sgst = $product_amount * 9 / 100;
        $sub_total = $product + $cgst + $sgst;
        $discount = 0;
        $final_amount =  $sub_total - $discount;
        $data = array(
            'price' => $product,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'subtotal' => $sub_total,
            'discount' => $checked,
            'final_amount' => $final_amount,
        );
        return $this->getMessage($data, config('constants.messages.success.apply_success'), config('constants.validation_codes.ok'), "true");
    }

    public function deletecoupen($id, Request $request)
    {
        if ($id != null) {
            $request['id'] = $id;
        } else {
            return $this->getMessage([], "coupan id required", config('constants.validation_codes.unauthorized'), false);
        }


        $rules = array(
            // 'name'  => "required|min:2|max:30|email",

            'id' => "exists:coupens,id",

        );
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        if (Auth::guard('api')->check()) {

            $delete = Coupen::find($id)->delete();
            if ($delete) {
                return $this->getMessage($delete, config('constants.messages.success.deleted_success'), config('constants.validation_codes.ok'), "true");
            }
        }
        return $this->getMessage([], config('constants.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }


    public function updatecoupen($id, Request $request)
    {
        if ($id != null) {
            $request['id'] = $id;
        } else {
            return $this->getMessage([], "coupan id required", config('constants.validation_codes.unauthorized'), false);
        }


        $rules = array(
            // 'name'  => "required|min:2|max:30|email",

            'id' => "exists:coupens,id",
            'code' => "required",
            'price' => 'required',
            'product' => 'required',
            'duration' => 'required|integer'
        );
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }
        if (Auth::guard('api')->check()) {

            $updatedata = Coupen::find($id);

            $updatedata->update($request->all());

            if ($updatedata) {
                return $this->getMessage($updatedata, config('constants.messages.success.updated_success'), config('constants.validation_codes.ok'), "true");
            }
        }
        return $this->getMessage([], config('constants.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }
    public function showcoupen($type = null)
    {

        if ($type == "desc"  && !is_null($type)) {
            $results = Coupen::orderBy('id', 'desc')->paginate(15);
            return $this->getMessage($results, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), "true");
        }
        $data = Coupen::paginate(15);
        return $this->getMessage($data, "Data Listed Succesfully", "200", true);
    }
}
