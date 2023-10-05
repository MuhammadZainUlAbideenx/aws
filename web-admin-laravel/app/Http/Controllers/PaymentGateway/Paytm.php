<?php

namespace App\Http\Controllers\PaymentGateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use paytm\paytmchecksum\PaytmChecksum;
use Str;

require_once("PaytmChecksum.php");
class Paytm extends Controller
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
            if ($setting->name == 'merchant_id') {
                $this->mid = $setting->value;
            }
            if ($setting->name == 'merchant_key') {
                $this->m_key = $setting->value;
            }
        }


        $this->headers['Content-Type'] = 'application/json';
    }
    public function generateBody($request, $customer)
    {
        $total = $request['current_currency_total'];
        $currency = $request['current_currency'];
        $url = config('app.url');
        $order_id = "PYTM_ORDR_" . Str::random(20);
        $customer_id = $customer->id;
        $paytmParams = array();

        $paytmParams["body"] = array(
            "requestType"   => "Payment",
            "mid"           => $this->mid,
            "websiteName"   => "WEBSTAGING",
            "orderId"       => $order_id,
            "callbackUrl"   => $url . "/processingPayment",
            "txnAmount"     => array(
                "value"     =>  $total,
                "currency"  => "INR",
            ),
            "userInfo"      => array(
                "custId"    => "CUST_".$customer_id,
            ),
        );


        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $this->m_key);

        $paytmParams["head"] = array(
            "signature"    => $checksum
        );

        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        /* for Staging */
        $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=$this->mid&orderId=$order_id";


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $response = curl_exec($ch);
        $decodedData = json_decode($response, true);
        if (isset($decodedData['body']['txnToken'])) {
            $txntoken = $decodedData['body']['txnToken'];
        }


        // process a payment
        $processPaytmParams["body"] = array(
            "requestType" => "NATIVE",
            "mid"         => $this->mid,
            "orderId"     => $order_id,
            "paymentMode" => "CREDIT_CARD",
            "cardInfo"    => "|" . $request['cardInfo']['number'] . "|" . $request['cardInfo']['cvc'] . "|" . $request['cardInfo']['exp_month'] ."28". $request['cardInfo']['exp_year'],
            "authMode"    => "otp",
        );
        // dd($processPaytmParams["body"]);
        if (isset($txntoken)) {
            $processPaytmParams["head"] = array(
                "txnToken"    => $txntoken
            );
        }

        $post_data = json_encode($processPaytmParams, JSON_UNESCAPED_SLASHES);
        $url = "https://securegw-stage.paytm.in/theia/api/v1/processTransaction?mid=$this->mid&orderId=$order_id";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        return $response;
    }
    public function executePayment($request, $customer)
    {
        $this->request = $request;
        $this->customer = $customer;
        return $this->sendRequest();
    }
    public function sendRequest()
    {
        $res = $this->generateBody($this->request, $this->customer);

        if ($res['body']['resultInfo']['resultStatus'] == 'S' || $res['body']['resultInfo']['resultMsg'] == 'Success') {
            $data['msg'] = $res['body']['resultInfo']['resultMsg'];
            return $data;
        } else {
            $data['msg'] = $res['body']['resultInfo']['resultMsg'];
            return $data;
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
