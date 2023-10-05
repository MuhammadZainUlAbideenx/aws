<?php

namespace App\Http\Controllers\PaymentGateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMSModels\Customer;
use App\Http\Resources\CMS\CustomersResource;
use Illuminate\Support\Facades\Http;
use Str;

class Flutterwave extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public $headers;
    public $body;
    public $payment_method;
    public $response;
    public $request;
    public $customer;
    public $access_token;
    protected $key_id;
    protected $key_secret;

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
            if ($setting->name == 'key_secret') {
                $this->key_secret = $setting->value;
            }
        }
        $this->headers['Authorization'] = "Bearer ".$this->key_secret;
        $this->headers['Accept'] = 'application/json';
    }
    public function generateBody($request, $customer)
    {

        $total = $request['current_currency_total'];
        $currency = $request['current_currency'];
        $url = config('app.url');
        $this->body = [
            "amount" => $total,
            "currency" => $currency,
            "tx_ref" => Str::random(10),
            "description" => "Payment for your order",
            "customer" => [
                "name" => $customer->first_name,
                "contact" => $customer->phone,
                "email" => $customer->email,
            ],
            "redirect_url" => $url . "/processingPayment",
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
        $this->generateBody($this->request, $this->customer);
        $res = HTTP::withHeaders($this->headers)->post('https://api.flutterwave.com/v3/payments', $this->body);
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
