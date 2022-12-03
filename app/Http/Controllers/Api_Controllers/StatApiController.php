<?php

namespace App\Http\Controllers\Api_Controllers;

use App\Http\Controllers\Controller;
use App\Traits\MessagesTrait;
use App\Models\state;
use Illuminate\Http\Request;

class StatApiController extends Controller
{
    use MessagesTrait;
    public function show()
    {
        $city = State::all();
        // return $city;
        return $this->getMessage($city, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), true);
    }
    public function single($id)
    {
        // dd($id);
        $state = State::all()->where('id', $id);
        return $this->getMessage($state, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), true);
    }
    public function countrywise($id)
    {
        $city = state::where('country_id', $id)->pluck('name');
        //   dd($city->count());
        if ($city->count() >= 0) {
            $state = State::all()->where('country_id', $id);
            return $this->getMessage($state, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), true);
        }
        return $this->getMessage([], config('constants.errors.content_not_found.'), config('constants.validation_codes.content_not_found'), false);
    }
}
