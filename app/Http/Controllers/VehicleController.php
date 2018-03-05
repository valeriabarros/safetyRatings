<?php

namespace App\Http\Controllers;

// use App\Http\Resources\VehicleResource;
// use App\Services\NHTSAService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;


class VehicleController extends Controller
{
    const API_URL = "https://one.nhtsa.gov/webapi/api/SafetyRatings/";

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getVehicle($year, $manufacturer, $model)
    {

        $client = new Client();
        $url = self::API_URL . "modelyear/" . $year .  "/make/" . $manufacturer . "/model/" .  $model . "?format=json";
        $response = $client->get($url);
        $result = json_decode($response->getBody()->getContents());
        
        $result = (object) [
            'Count' => $result->Count,
            'Results' => array_map(function($item) {
                return (object) [
                    'Description' => $item->VehicleDescription,
                    'VehicleId' => $item->VehicleId
                ];
            }, $result->Results)
        ];

        if (Input::get('withRating') === "true") {
            
            $ratings = [];
            foreach ($result->Results as $key => $vehicle) {
                $urlRatings = self::API_URL . 'VehicleId/' . $vehicle->VehicleId  . '?format=json';
                $responseRatings = $client->get($urlRatings);
                $resultRatings = json_decode($responseRatings->getBody()->getContents());
                $ratings[$vehicle->VehicleId] = $resultRatings->Results[0]->OverallRating;
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

    //    @todo validate entry data
        $client = new Client();
        $url = self::API_URL . "modelyear/" . $year .  "/make/" . $manufacturer . "/model/" .  $model . "?format=json";
        $response = $client->get($url);

        // @to-do 
        $result = json_decode($response->getBody()->getContents());
        
        $result = (object) [
            'Count' => $result->Count,
            'Results' => array_map(function($item) {
                return (object) [
                    'Description' => $item->VehicleDescription,
                    'VehicleId' => $item->VehicleId
                ];
            }, $result->Results)
        ];

        return Response::json($result);
    }



}
