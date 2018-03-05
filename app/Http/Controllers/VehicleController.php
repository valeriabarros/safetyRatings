<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use App\Services\VehicleService;

/**
 * Vehicle controller class.
 */
class VehicleController extends Controller
{
    /**
     * Format the data returned by the controller.
     *
     * @param [array] $data
     * @return json
     */
    private function makeResponse($data) {
        return Response::json(
            (object) [
                'Count' => count($data),
                'Results' => $data
            ]
        );
    }

    /**
     * Get vehicles.
     *
     * @param [string] $year
     * @param [string] $manufacturer
     * @param [string] $model
     * @return json
     */
    public function getVehicle($year, $manufacturer, $model)
    {
        $vehicles = (new VehicleService())
            ->getVehicles($year, $manufacturer, $model, (bool) (Request::input('withRating') === 'true'));

        return $this->makeResponse($vehicles);
    }

    /**
     * Return vehicles by content body.
     *
     * @return json
     */
    public function postVehicle()
    {   
        $vehicles = (new VehicleService())
            ->getVehicles(
                Request::input('modelYear'),
                Request::input('manufacturer'),
                Request::input('model')
            );
       
        return $this->makeResponse($vehicles);
    }
}
