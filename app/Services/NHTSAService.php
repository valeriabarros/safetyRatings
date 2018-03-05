<?php

namespace App\Services;
 
use App\Helpers\NHTSAClient;

class NHTSAService 
{
    const API_URL = "https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/2015";

    public function getApiClient() 
    {
        $client = new NHTSAClient();
        dd($client->client);
    }
}