<?php

namespace App\Http\Controllers\PaymentGateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Customer;
use App\Http\Resources\CMS\CustomersResource;
use Illuminate\Support\Facades\Http;
use Str;

class Mollie extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public $headers;
    public $body;
    public $payment_method;
    public $response;
    public $request;
    public $customer;
    public $access_token;
    protected $public_key;
    protected $secret_key;
    protected $api_key;

    public function __construct()
    {
    }
    // Posts
    public function index(Request $request)
    {
    }
    public function setAuthorizationKeys($payment_method)
    {
        foreach ($payment_method as $setting) {
            if ($setting->name == 'api_key') {
                $this->api_key = $setting->value;
            }
        }
        $this->headers['Authorization'] = "Bearer ".$this->api_key;
        // $this->headers['Accept'] = 'application/json';
    }
    public function generateBody($request)
    {
        $total = $request['current_currency_total'];
        $currency = $request['current_currency'];
        $url = config('app.url');
        $this->body = [
            "amount" => [
                "currency" => "EUR",
                "value" =>  $total,
            ],
            "description" => 'Shopping from nictus ecommerce',
            // "email" => "usman@gmail.com",
            // "customer" => [
            //     "name" => "Gaurav Kumar",
            //     "contact" => "+919999999999",
            //     "email" => "gaurav.kumar@example.com"
            // ],
            "redirectUrl" => $url . "/processingPayment",
            // "redirectUrl" => "http://localhost:3000/processingPayment",
        ];
    }
    public function executePayment($request, $customer)
    {
        $this->request = $request;
        $this->customer = $customer;
        return $this->sendRequest();
    }
    public function sendRequest()
    {
        $this->generateBody($this->request);
        $res = HTTP::withHeaders($this->headers)->post('https://api.mollie.com/v2/payment-links', $this->body);
        if ($res->successful() || $res->ok()) {
            $body = json_decode($res->body());
            return $body;
        } else {
            return $res->body();
        }
    }

    public function authorizeWithoutCapture()
    {
    }
    public function authorizeWithCapture()
    {
    }
    public function Response($res)
    {
        $body = json_decode($res->body());
        if ($res->successful() || $res->ok()) {
            $data['receipt_email'] = '';
            $data['metadata'] = '';
            $data['intent_id'] = $body->id;
            $data['capture_id'] = $body->id;
            $data['shipping_details'] = '';
            $response['data'] = $data;
            $response['success'] = true;
            $response['captured'] = false;
            $response['authorization_required'] = true;
            foreach ($body->links as $link) {
                if ($link->rel == 'approve') {
                    $response['authorization_url'] = $link->href;
                }
            }
            $response['return_url'] = '';
            $response['status'] = '200';
            return $response;
        } else {
            if ($body->message) {
                $error['message'] = $body->message;
                $response['data'] = $error;
            }
            $response['success'] = false;
            $response['captured'] = false;
            $response['status'] = $res->status();
            return $response;
        }
    }
    public function verifyPayment($params)
    {
        $res = HTTP::withHeaders($this->headers)->asForm()->post('https://api.razorpay.com/v1/payment_links', [
            'grant_type' => 'client_credentials',
        ]);
        if ($res->successful() || $res->ok()) {
            $token = json_decode($res->body());
            $this->access_token = $token->access_token;
            $this->headers['Authorization'] = 'Bearer ' . $this->access_token;
            $res = Http::withHeaders($this->headers)->post('https://api.sandbox.paypal.com/v2/checkout/orders/' . $params['token'] . '/capture');
            return $this->Response($res);
        } else {
            return $this->Response($res);
        }
    }
}
