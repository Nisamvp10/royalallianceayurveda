<?php
namespace App\Services;

class Producttracking {
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->token  = getenv('shipbudddy.api_key');
        $this->baseUrl = 'https://api.shypbuddy.net/api/';
    }


    public function track($trackingNumber = null)
    {

        $token = $this->token;

        $url = "https://api.shypbuddy.net/api/direct-api/shipment-tracking?awbNumbers=368974669556";

        $ch = curl_init();

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->token,
            'origin: https://royalallianceayurveda.com'
        ];

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $token,
                'Accept: application/json',
                'origin: https://royalallianceayurveda.com'
            ],
        ]);

        $response = curl_exec($ch);
       
        if (curl_errno($ch)) {
            return [
                'status' => false,
                'error' => curl_error($ch)
            ];
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}