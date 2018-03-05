<?php
namespace App\Helpers;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class NHTSAClient 
{
    const API_URL = "https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/2015";
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::API_URL
        ]);
    }
}

