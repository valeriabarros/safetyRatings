<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;
 
/**
 * Vehicle Service.
 * Get information from NHTSA public API.
 */
class VehicleService 
{
    const API_URL = "https://one.nhtsa.gov/webapi/api/SafetyRatings/";
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Get vehicles.
     *
     * @param [string] $year
     * @param [string] $manufacturer
     * @param [string] $model
     * @param boolean $withRating
     * @return array
     */
    public function getVehicles($year, $manufacturer, $model, $withRating = false)
    {
        if (empty($year) || empty($manufacturer) || empty($model)) 
            return array();

        try {
            $response = $this->client->get(self::API_URL . "modelyear/{$year}/make/{$manufacturer}/model/{$model}?format=json");
        } catch (Exception $e) { return array(); }

        return array_map(function ($vehicle) use (&$withRating) {
            $newVehicle = (object)[
                'VehicleId' => $vehicle->VehicleId,
                'Description' => $vehicle->VehicleDescription
            ];

            if ($withRating)
                $newVehicle->CrashRating = $this->getVehicleCrashRating($vehicle->VehicleId);
            
            return $newVehicle;
        }, json_decode($response->getBody()->getContents())->Results);
    }

    /**
     * Get vehicle crash rating.
     *
     * @param [string] $vehicleId
     * @return string
     */
    private function getVehicleCrashRating($vehicleId)
    {
        $response = $this->client->get(self::API_URL . "VehicleId/{$vehicleId}?format=json");

        return json_decode($response->getBody()->getContents())->Results[0]->OverallRating;
    }
}