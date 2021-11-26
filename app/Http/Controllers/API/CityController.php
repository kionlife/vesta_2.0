<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends BaseController
{
    public function index(Request $request)
    {
        return $this->sendResponse(new CityResource(City::all()), 'Cities retrieved successfully.');
    }
}
