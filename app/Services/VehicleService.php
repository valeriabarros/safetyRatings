<?php

namespace App\Services;

use GuzzleHttp\Client;
 
class VehicleService 
{
    const API_URL = "https://one.nhtsa.gov/webapi/api/SafetyRatings/";


   public static function getVehicles($year, $manufacturer, $model)
   {
        $client = new Client();
        $response = $client->get(self::API_URL . "modelyear/{$year}/make/{$manufacturer}/model/{$model}?format=json");
        return json_decode($response->getBody()->getContents());
   }

   public static function getVehicleInfo($vehicleId)
   {
       $client = new Client();
       $response = $client->get(self::API_URL . "VehicleId/{$vehicleId}?format=json");
       return json_decode($response->getBody()->getContents());
   }
}