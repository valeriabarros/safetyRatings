<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use App\Services\VehicleService;


class VehicleController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getVehicle($year, $manufacturer, $model)
    {
        $vehicles = VehicleService::getVehicles($year, $manufacturer, $model);       
        
        $result = (object) [
            'Count' => $vehicles->Count,
            'Results' => array_map(function($item) {
                return (object) [
                    'Description' => $item->VehicleDescription,
                    'VehicleId' => $item->VehicleId
                ];
            }, $vehicles->Results)
        ];

        if (Request::input('withRating') === "true") {
            
            $ratings = [];
            foreach ($result->Results as $key => $vehicle) {
               $info = VehicleService::getVehicleInfo($vehicle->VehicleId);
               $ratings[$vehicle->VehicleId] = $info->Results[0]->OverallRating;
            }

            $result->Results = array_map(function($item) use (&$ratings) {
                $item->CrashRating = $ratings[$item->VehicleId];
                return $item;
            }, $result->Results);
        }

        return Response::json($result);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postVehicle()
    {   
       $year = Request::input('modelYear');
       $manufacturer = Request::input('manufacturer');
       $model = Request::input('model');
       $vehicles = VehicleService::getVehicles($year, $manufacturer, $model);

        $result = (object) [
            'Count' => $vehicles->Count,
            'Results' => array_map(function($item) {
                return (object) [
                    'Description' => $item->VehicleDescription,
                    'VehicleId' => $item->VehicleId
                ];
            }, $vehicles->Results)
        ];

        return Response::json($result);
    }
}
