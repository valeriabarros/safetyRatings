<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use App\Services\VehicleService;
use Exception;


class VehicleController extends Controller
{
    private function makeResponse($data) {
        return Response::json(
            (object) [
                'Count' => count($data),
                'Results' => $data
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function getVehicle($year, $manufacturer, $model)
    {
        $service = new VehicleService();

        $vehicles = $service->getVehicles($year, $manufacturer, $model);
        if (Request::input('withRating') === "true") {
            $vehicles = array_map(function ($vehicle) use (&$service) {
                $vehicle->CrashRating = $service->getVehicleCrashRating($vehicle->VehicleId);
                return $vehicle;
            }, $vehicles);
        }

        return $this->makeResponse($vehicles);
    }

    /**
     * Display the specified resource.
     */
    public function postVehicle()
    {   
        $service = new VehicleService();
        $vehicles = $service->getVehicles(
            Request::input('modelYear'),
            Request::input('manufacturer'),
            Request::input('model')
        );
       
        return $this->makeResponse($vehicles);
    }
}
