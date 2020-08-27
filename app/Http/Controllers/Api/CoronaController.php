<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CoronaController extends Controller
{
    public function index() {
        $rapidApi = Http::withHeaders([
            'x-rapidapi-host' => 'covid-19-data.p.rapidapi.com',
            'x-rapidapi-key' => '39f9bc0c33mshed4a3af8b0e5ce7p1a0857jsnbf942780036b'
        ]);
        $response = $rapidApi->get('https://covid-19-data.p.rapidapi.com/help/countries');
        $responseArr = $response->json();
        $countries = array_slice($responseArr, 0, 3);
        sleep(1);
        $dataPoints = [];
        foreach ($countries as $key => $country) {
            $params = [
                'format' => 'json',
	            'name' => $country["name"]
            ];
            $latesCountryData = $rapidApi->get('https://covid-19-data.p.rapidapi.com/country', $params)->json();

            if (!$latesCountryData) {
                continue;
            }
            $dataPoint['x'] = $latesCountryData[0]["confirmed"];
            $dataPoint['lable'] = $latesCountryData[0]["country"];
            array_push($dataPoints, $dataPoint);
            sleep(1);

        }
        
        return response()->json($dataPoints, 200);
    }
}
