<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;
 
class VehicleService 
{
    const API_URL = "https://one.nhtsa.gov/webapi/api/SafetyRatings/";
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getVehicles($year, $manufacturer, $model)
    {
        if (empty($year) || empty($manufacturer) || empty($model)) 
            throw new Exception("Invalid Input");
        
        $response = $this->client->get(self::API_URL . "modelyear/{$year}/make/{$manufacturer}/model/{$model}?format=json");

        return array_map(function ($vehicle) {
            return (object) [
                'VehicleId' => $vehicle->VehicleId,
                'Description' => $vehicle->VehicleDescription
            ];
        }, json_decode($response->getBody()->getContents())->Results);
    }

    public function getVehicleCrashRating($vehicleId)
    {
        $response = $this->client->get(self::API_URL . "VehicleId/{$vehicleId}?format=json");

        return json_decode($response->getBody()->getContents())->Results[0]->OverallRating;
    }
}