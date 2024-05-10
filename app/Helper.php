<?php

namespace App\Helper;

class Helper
{
    protected static ?string $api_url = 'https://api.easywa.id/v1/';
    protected static ?string $easywa_email = '';
    protected static ?string $easywa_apikey = '';


    public static function response($code, $status, $data, $message)
    {
        return response()->json([
            'code' => $code,
            'status' => $status,
            'data' => $data,
            'message' => $message
        ]);
    }

    public static function http($url, $method, $body = null, $headers = [])
    {

        $client = new \GuzzleHttp\Client();
        if ($body == null) {
            $response = $client->request($method, $url, [
                'headers' => $headers
            ]);
        } elseif ($headers == null) {
            $response = $client->request($method, $url, [
                'form_params' => $body
            ]);
        } else {
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

    public static function sendWhatsappMessage($number, $message)
    {

        self::$easywa_email = env('EASYWA_EMAIL');
        self::$easywa_apikey = env('EASYWA_APIKEY');

        $endpoint = self::$api_url . 'send-message';
        $headers = [
            'email' => self::$easywa_email,
            'secret-key' => self::$easywa_apikey
        ];

        $body = [
            'number' => $number,
            'message' => $message,
            'type' => 'sync',
            'delay' => 0
        ];

        return self::http($endpoint, 'POST', $body, $headers);
    }

   public static function replacer($content,$replaces= [])
   {
         foreach ($replaces as $key => $value) {
              $content = str_replace('{'.$key.'}', $value, $content);
         }
         return $content;
   }

   public static function passwordGenerator($length = 8)
   {
        $password = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $length)), 0, $length);
        return $password;
   }
}
