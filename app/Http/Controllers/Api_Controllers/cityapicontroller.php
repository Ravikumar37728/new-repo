<?php

namespace App\Http\Controllers\Api_Controllers;

use App\Http\Controllers\Controller;
use App\Traits\MessagesTrait;
use App\Models\city;

use Illuminate\Http\Request;

class cityapicontroller extends Controller
{
    use MessagesTrait;

    public function show()
    {
        // User can show all the cities 
        $city = city::all();

        return $this->getMessage($city, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), "true");
    }
    public function single($id)
    {
        // User can show all the cities depend on city id 

        $state = city::all()->where('id', $id);
        return $this->getMessage($state, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), true);
    }
    public function statewise($id)
    {
        // User can show all the cities  depend on state id 

        $city = city::where('state_id', $id)->pluck('name');
        //  dd($city->count());
        if ($city->count() >= 0) {

            $state = city::all()->where('state_id', $id);

            return $this->getMessage($state, config('constants.messages.success.showed_success'), config('constants.validation_codes.ok'), true);
        }
        return $this->getMessage([], config('constants.errors.content_not_found.'), config('constants.validation_codes.content_not_found'), false);
    }
}
