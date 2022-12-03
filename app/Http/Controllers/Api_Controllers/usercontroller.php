<?php

namespace App\Http\Controllers\Api_Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePassworeRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\loginrequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\support\Facades\DB;
use App\Traits\MessagesTrait;

use Illuminate\Support\Facades\Validator;


class usercontroller extends Controller
{
    public $successStatus = 200;
    use MessagesTrait;
    public function login(loginrequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (is_null($user)) {
            return $this->getMessage([], "Email ID doesn't Exist!", config('constants.validation_codes.content_not_found'), false);
        }
        if (!Hash::check($request->password, $user->password)) {
            return $this->getMessage([], config('constants.messages.errors.login.invalid_password'), config('constants.validation_codes.unprocessable_entity'), false);
        }
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $user['token'] = $user->createToken('MyApp')->accessToken;
            return $this->getMessage($user, config('constants.messages.success.login_success'), config('constants.validation_codes.ok'), true);
        } else {
            return $this->getMessage(
                [],
                config('constants.messages.errors.token_not_found'),
                config('constants.validation_codes.unauthorized'),
                False
            );
        }
    }
    public function register(Request $request)
    {
        $check = Db::table('users')->where(['email' => $request->email])->get();
        // dd($check->count());
        if (!$check->count() > 0) {
            $user = new User;
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $input['user_type'] = '2';
            $user = User::create($input);

            // return()
            return $this->getMessage($user, config('constants.messages.success.stored_success'), config('constants.validation_codes.created'), true);
        } else
            return $this->getMessage([], config('constants.messages.success.email_already'), config('constants.validation_codes.unprocessable_entity'), true);
    }

    public function details()
    {
        if (!Auth::guard('api')->check()) {
            return $this->getMessage([], config('constants.messages.errors.token_not_found'), config('constants.validation_codes.unauthorized'), false);
        }

        $details = auth()->guard('api')->user();
        return $this->getMessage($details, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), true);
    }
    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();
        $accessToken = $user->token();
        $accessToken->revoke();
        $user->update(['divice_id' => NULL]);
        return $this->getMessage([], config('constants.messages.success.logout_success'), config('constants.validation_codes.ok'), true);

        // return $this->getMessage([], config("constants.messages.success.logout_success"), config('constants.validation_codes.ok'), true);
    }
    public function changepassword(ChangePassworeRequest $request)
    {
        $user = User::where(['id' => Auth::guard('api')->id()])->first();
        if (is_null($user)) {
            return $this->getMessage([], config('constants.messages.errors.content_not_found'), config('constants.validation_codes.content_not_found'), true);
        }
        if (!Hash::check($request['old_password'], $user->password)) {
            return $this->getMessage([], config("constants.messages.errors.change_password.invalid_old_password"), config('constants.validation_codes.unprocessable_entity'), false);
        }
        $pass = bcrypt($request['new_password']);
        if ($user->update(['password' => $pass])) {
            return $this->getMessage([], config('constants.messages.success.password_changed_success'), config('constants.validation_codes.ok'), true);
        } else {
            return $this->getMessage([], config("constants.messages.errors.something_wrong"), config('constants.validation_codes.unprocessable_entity'), false);
        }
    }

    public function forgotpassword(Request $request)
    {
        $rules = array(
            'email' => 'required|email'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }


        $user = User::where('email', $request->email)->first();

        if ($user == null) {
            return $this->getMessage([], config('constants.messages.errors.content_not_found'), config('constants.validation_codes.content_not_found'), false);
        }
        $otp = rand(1, 999999);
        $user->email_otp = $otp;
        $user->save();
        $email = $request->email;
        $details = [
            'email' => $email,
            'otp' => $otp
        ];
        Mail::to($email)->send(new  \App\Mail\Sendpasswordotp($details));



        // $mail = Mail::to($request->email)->send(new SendEmailOtp($otp));
        // if ($mail) {
        //     return $this->getMessage([], config('constants.messages.success.forgot_password_success'), config('constants.validation_codes.ok'), true);
        // } else {
        //     return $this->getMessage([], config("constants.messages.errors.something_wrong"), config('constants.validation_codes.unprocessable_entity'), false);
        // }
    }

    public function otpverify(Request $request)
    {
        $rules = array(
            'otp' => 'required|min:6|numeric',
            'email' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $otp = db::table('users')->where('email', $request->email)->first('email_otp')->email_otp;

        $user = User::where('email', $request->email)->first();
        if ($otp == $request->otp) {
            $rules = array(
                'new_password' => 'required|required_with:confirm_password|same:confirm_password|min:6|max:191|different:old_password',
                'confirm_password' => 'required|min:6|max:191',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $validator->errors();
            }
            $pass = bcrypt($request['new_password']);
            if ($user->update(['password' => $pass])) {
                return $this->getMessage([], config('constants.messages.success.password_reset_success'), config('constants.validation_codes.ok'), true);
            }
        }
        return $this->getMessage([], config('constants.messages.errors.otp_invalid'), config('constants.validation_codes.unprocessable_entity'), false);
    }
}
