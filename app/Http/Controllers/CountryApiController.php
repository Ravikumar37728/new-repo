<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Traits\MessagesTrait;

class CountryApiController extends Controller
{
    use MessagesTrait;
    public function show()
    {
        $city = Country::all();
        return $this->getMessage($city, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), "true");
    }
    public function single($id)
    {
        // dd($id);
        $state = country::all()->where('id', $id);
        return $this->getMessage($state, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), "true");
    }
}
