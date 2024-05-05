<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EasywaController extends Controller
{
    protected ?string $api_url = 'https://api.easywa.id/v1/';
    protected ?string $easywa_email = '';
    protected ?string $easywa_apikey = '';

    public function __construct()
    {
        $this->easywa_email = env('EASYWA_EMAIL');
        $this->easywa_apikey = env('EASYWA_APIKEY');
    }

    public function http($url , $method,$body = null,$headers = [])
    {

        $client = new \GuzzleHttp\Client();
        if($body == null){
            $response = $client->request($method, $url, [
                'headers' => $headers
            ]);
        }elseif($headers == null){
            $response = $client->request($method, $url, [
                'form_params' => $body
            ]);
        }else{
            $response = $client->request($method, $url, [
                'headers' => $headers,
                'form_params' => $body
            ]);
        }

        return response()->json([
            'code' => $response->getStatusCode(),
            'status' => 'success',
            'data' => json_decode($response->getBody()),
            'message' => 'Request success'
        ]);
    }

    public function sendMessage(Request $request)
    {
        $number = $request->number;
        $message = $request->message;
        $endpoint = $this->api_url.'send-message';
        $headers = [
            'email' => $this->easywa_email,
            'secret-key' => $this->easywa_apikey
        ];

        $body = [
            'number' => $number,
            'message' => $message,
            'type' => 'sync',
            'delay'=> 0
        ];

        return $this->http($endpoint,'POST',$body,$headers);
    }
}
