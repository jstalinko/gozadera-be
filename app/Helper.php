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

    public static function replacer($content, $replaces = [])
    {
        foreach ($replaces as $key => $value) {
            $content = str_replace('{' . $key . '}', $value, $content);
        }
        return $content;
    }

    public static function passwordGenerator($length = 8)
    {
        $password = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $length)), 0, $length);
        return $password;
    }

    public static function invoice($id, $outlet_id)
    {
        $invoice = date('Ymd') . $id . $outlet_id . rand(100, 999);
        return $invoice;
    }
    public static function saveSvgToPng($base64_string, $filename)
    {
        $output_file = public_path('storage/userqr/' . $filename . '.svg');

        if (!file_exists($output_file)) {

            if (!file_exists(public_path('storage/userqr'))) {
                mkdir(public_path('storage/userqr'), 0777, true);
            }
            $ifp = fopen($output_file, 'wb');

            // split the string on commas
            // $data[ 0 ] == "data:image/png;base64"
            // $data[ 1 ] == <actual base64 string>
            $data = explode(',', $base64_string);

            // we could add validation here with ensuring count( $data ) > 1
            fwrite($ifp, base64_decode($data[1]));

            // clean up the file resource
            fclose($ifp);
        }

        return asset('storage/userqr/' . $filename.'.svg');
    }
}
