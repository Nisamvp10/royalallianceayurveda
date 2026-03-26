<?php
namespace App\Services;

class PaymentGateway {
    private string $keyId;
    private string $keySecret;
    private string $webhookSecret;
    private string $baseUrl;
    public function __construct() {
        //stored .env variables
        $this->keyId = (string) env('payment.keyId');
        $this->keySecret = (string) env('payment.keySecret');
        $this->webhookSecret = (string) env('payment.webhookSecret');
        $this->baseUrl = env('payment.baseUrl');
    }

    public function createOrder($amount,$receipt)
    {
        $user = session()->get('user');
        $url = "https://api.razorpay.com/v1/orders";
        // $url = "https://api.razorpay.com/v1/payouts";

        $data = [
            "amount" => round($amount * 100),
            "currency" => "INR",
            "receipt" => $receipt,
            "payment_capture" => 1
        ];

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => $this->keyId . ":" . $this->keySecret,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }

        curl_close($ch);

        return json_decode($response, true);
    }  
    
}