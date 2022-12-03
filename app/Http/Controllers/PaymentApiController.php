<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\MessagesTrait;

use App\Http\Requests\paymentrequest;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription;
use Illuminate\Support\Facades\Validator;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class PaymentApiController extends Controller
{
    use MessagesTrait;
    public function payments($id, paymentrequest $request)
    {
        if($id!= null){
            $request['id']=$id;
        }else{
            return $this->getMessage([], "product id required", config('constants.validation_codes.unauthorized'), false);

        }


        $rules = array(
            // 'name'  => "required|min:2|max:30|email",

            'id'=>"exists:products,id",

        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }
        // Store Payment Details
        $product_price = db::table('products')->where('id', $id)->first("price")->price;
        $product_name = db::table('products')->where('id', $id)->first("name")->name;
        $userdata = new Subscription();
        $userdata->firstname = $request->firstname;
        $userdata->lastname = $request->lastname;
        $userdata->email = $request->email;
        $userdata->address = $request->address;
        $userdata->couuntry = $request->country;
        $userdata->state = $request->state;
        $userdata->city = $request->city;
        $userdata->pincode = $request->pincode;
        $userdata->phone_no = $request->phoneno;
        $userdata->product_name = $product_name;
        $userdata->product_price = $product_price;
        $userdata->save();
        return $this->getMessage($userdata, "Data Inserted Succesfully", "200", true);
    }

    public function updatestatus(request $request)
    {
        $rules = array(
            'user_id' => 'required|exists:users,id',
            'payment_status' => 'required',
            'product_id' => 'required|exists:products,id'
        );
        $validator = validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $product = db::table('products')->where('id', $request->product_id)->first("name")->name;

        $check = db::table('subscriptions')->where(['id' => $request->user_id])->get();
        $updatedata = Subscription::find($request->user_id);

        //Update User's Payment details like price or cgst or gst
        $updatedata->update($request->all());


        if (!$check->count() > 0) {
            return $this->getMessage([], config('constants.messages.errors.invalid'), config('constants.validation_codes.not_found'), "true");
        }
        if ($request->payment_status == config('constants.payments.status.2')) {
            return $this->getMessage([], config('constants.messages.success.payment_cancel'), config('constants.validation_codes.unprocessable_entity'), "true");
        }
        if ($request->payment_status == "1") {

            Subscription::where(['id' => $request->user_id, 'product_name' => $product])->update(['payment_status' => "1"]);
            $verify =  db::table("subscriptions")->where(['id' => $request->user_id, 'product_name' => $product, 'payment_status' => "1"])->get('id');

            if (!$verify->count() == 1) {
                return $this->getMessage([], config('constants.messages.errors.something_wrong'), config('constants.validation_codes.unprocessable_entity'), "true");
            }
            $user = Subscription::where('id', $request->user_id)->first();
            // dd($user);
            $username = $user->firstname . " " . $user->lastname;

            // Make  Invoice
            $invoice['user_id'] = $request->user_id;
            $invoice['invoice_no'] = "";
            $invoice['user_name'] = $username;
            $invoice['user_email'] = $user['email'];
            $invoice['user_phone'] = $user->phone_no;
            $invoice['user_address'] = $user->address;
            $invoice['user_country_name'] = $user->couuntry;
            $invoice['user_state_name'] = $user->state;
            $invoice['user_city_name'] = $user->city;
            $invoice['user_pin_code'] = $user->pincode;
            $invoice['plan_name'] = $user->product_name;
            $invoice['plan_amount'] = $user->product_price;
            $invoice['cgst_amount'] = $user->cgst;
            $invoice['sgst_amount'] = $user->sgst;
            $invoice['discount'] = $user->discount;
            //  dd($invoice['discount']);
            $invoice['total_amount'] = $user->amount;
            $invoice['gst_amount'] = $invoice['cgst_amount'] + $invoice['sgst_amount'];
            $invoice = Invoice::create($invoice);
            $invoice_number = str_pad('IB-', 11, str_pad($invoice->id, 8, '0', STR_PAD_LEFT), STR_PAD_RIGHT);
            $invoice->update(['invoice_no' => $invoice_number]);
            $in = $invoice->toarray();

            // Make PDF  of invoice
            $pdf = PDF::loadView('mail', $in)->setOptions(['defaultFont' => 'sans-serif']);

            // Send PDF  to a user mail
            Mail::send('mail', $in, function ($message) use ($in, $pdf) {
                $message->to($in["user_email"], $in["user_email"])
                    ->subject("Purchase Invoice")

                    ->attachData($pdf->output(), "invoice.pdf");
            });

            return $pdf->download('invoice.pdf');

            // return $this->getMessage($pdf, 'Thank You For Subscribe', "201", true);
        }
    }

    public function payment_product_details($id, Request $request)
    {
        if($id!= null){
            $request['id']=$id;
        }else{
            return $this->getMessage([], "product id required", config('constants.validation_codes.unauthorized'), false);

        }


        $rules = array(
            // 'name'  => "required|min:2|max:30|email",

            'id'=>"exists:products,id",

        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $product = db::table('products')->where('id', $id)->first("price")->price;
        $cgst = $product * 9 / 100;
        $sgst = $product * 9 / 100;

        $sub_total = $product + $cgst + $sgst;
        $discount = $request->discount;
        $final_amount =  $sub_total - $discount;
        $data = array(
            'price' => $product,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'subtotal' => $sub_total,
            'discount' => $discount,
            'final_amount' => $final_amount,
        );
        return $this->getMessage($data, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), "true");
    }

    public function showpayment($type = null)
    {
        if (Auth::guard('api')->check()) {
            //  $payments= Subscription::where('payment_status',"1")->get();

            if ($type == "desc"  && !is_null($type)) {
                $results = Subscription::where('payment_status', "1")->orderBy('id', 'desc')->paginate(15);
                return $this->getMessage($results, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), "true");
            }
            $data = Subscription::where('payment_status', "1")->paginate(15);
            return $this->getMessage($data, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), "true");
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
        //   $payments= Subscription::where('payment_status',"1")->get();
    }
}
