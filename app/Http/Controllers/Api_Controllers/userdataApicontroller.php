<?php

namespace App\Http\Controllers\Api_Controllers;

use App\Traits\SspfTraitrait;
use App\Models\userdata;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Resources\CommonCollection;
use App\Http\Resources\candidateresource;
use App\Http\Controllers\Controller;
use App\Http\Requests\userrequest;
use App\Models\vacancy;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\MessagesTrait;
use App\Traits\SspfTrait;
use Illuminate\Support\Facades\Validator;

class userdataApicontroller extends Controller
{
    // use SspfTrait;
    use MessagesTrait;
    public function store($id, userrequest $request)
    {
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
        $product = db::table('products')->where('id', $id)->first("name")->name;
        $userdata = new userdata;
        $userdata->firstname = $request->fname;
        $userdata->lastname = $request->lname;
        $userdata->email = $request->email;
        $userdata->phone_no = $request->phone_no;
        $userdata->product_name = $product;
        $userdata->save();
        if ($userdata->save()) {
            return $this->getMessage($userdata, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), true);
        }
        return $this->getMessage($userdata, "Data Inserted Succesfully", "200", true);
    }

    public function show($type = null)
    {

        if (Auth::guard('api')->check()) {

            if ($type == "desc"  && !is_null($type)) {
                $results = userdata::where('payment_status', '1')->orderBy('id', 'desc')->paginate(15);
                return $this->getMessage($results, "Data Listed Succesfully", "200", true);
            }
            $data = userdata::where('payment_status', '1')->paginate(15);

            return $this->getMessage($data, "Data Listed Succesfully", "200", true);
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }

    public function candidateform($vacancyid, request $request)
    {
        if ($vacancyid != null) {
            $request['vacancyid'] = $vacancyid;
        } else {
            return $this->getMessage([], "vacancy id required", config('constants.validation_codes.unauthorized'), false);
        }



        $rules = array(
            'vacancyid' => 'required|exists:vacancy,id',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phoneno' => 'required|numeric',
            'resume' => 'required|mimes:pdf,doc,docx'
        );
        $validator = validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $candidate = new Candidate(); {
            $candidate->firstname = $request->firstname;
            $candidate->lastname = $request->lastname;
            $candidate->email = $request->email;
            $candidate->phoneno = $request->phoneno;
            $candidate->work_experience = $request->work_experience;
            $candidate->current_ctc = $request->current_ctc;
            $candidate->location = $request->location;
            $candidate->address = $request->address;
            $candidate->messages = $request->messages;


            $candidate->position = vacancy::where('id', $vacancyid)->first('position')->position;
            if ($request->file('resume')) {
                $file = $request->file('resume');
                $resumeName = Str::random(30);
                $destinationPath = "public/resumes/";
                $filename = $resumeName . '' . '.' . $file->extension();
                Storage::putFileAs($destinationPath, $file, $filename);
                $candidate->resume = $filename;
            }
            $candidate->save();
            return new candidateresource($candidate);
            // return $this->getMessage($candidate, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), true);
        }
    }

    public function showcandidate()
    {
        if (Auth::guard('api')->check()) {
            // $model = new $model();
            $data = Candidate::paginate(15);
            return  new CommonCollection(candidateresource::collection($data), candidateresource::class);
            // if (isset($candidate)) {
            //     $results = Candidate::where('id', $candidate)->first();
            //     // dd($results);
            //     return (new candidateresource($results))->additional([
            //         'status' => true,
            //         'status_code' => "200",
            //         'Message' => 'Data Listed Succesfully'
            //     ]);
            // }
            // dd("ss");

            // if ($type == "desc"  && !is_null($type)) {
            //     $results = Candidate::paginate(1);
            //     return (new candidateresource($results))->additional([
            //         'status' => true,
            //         'status_code' => "200",
            //         'Message' => 'Data Listed Succesfully'
            //     ]);
            // }
            // return $this->getMessage($data, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), true);
        }
        return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
    }
}
