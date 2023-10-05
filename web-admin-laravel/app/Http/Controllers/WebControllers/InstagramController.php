<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Models\CMSModels\Setting;
use Illuminate\Http\Request;
use Phpfastcache\Helper\Psr16Adapter;

class InstagramController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {
    }

    public function instagram()
    {
        $allSettings = Setting::select('name', 'value')->pluck('value', 'name')->toArray();
        $instagram_app_id = $allSettings['instagram_app_id'];
        $instagram_app_secret = $allSettings['instagram_secret_key'];
        $instagram_app_code = $allSettings['instagram_app_code'];
        if (isset($allSettings['long_lived_access_token_instagram'])) {
            $long_lived_access_token_instagram = $allSettings['long_lived_access_token_instagram'];
        } else {
            $long_lived_access_token_instagram = '';
        }
        if ($long_lived_access_token_instagram) {
            // Fetch Media Instagram
            // $fields = "id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username";
            $fields = "media_url,permalink";
            $token = $long_lived_access_token_instagram;
            $limit = 20;

            // new code starts


            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.instagram.com/me/media?fields=' . $fields . '&access_token=' . $token . '&limit=' . $limit,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: csrftoken=nbzgGORrhZbxiygaMAzChnZWWQWnF5WX; ig_did=C37F3331-07D6-4343-9699-1A080395FE5A; ig_nrcb=1; mid=Yn32TAAEAAHsoru7zk_pB1caueDF'
                ),
            ));

            $response = curl_exec($curl);
            if ($response) {

                curl_close($curl);
                // echo $response;
                return response($response);
                // new code ends



                // $json_feed_url = "https://graph.instagram.com/me/media?fields={$fields}&access_token={$token}&limit={$limit}";
                // dd($json_feed_url);
                // $json_feed = @file_get_contents($json_feed_url);
                // dd("json feed", $json_feed);

                // check if post is available

                // $contents = json_decode($json_feed, true, 512, JSON_BIGINT_AS_STRING);
                // dd("contents", $contents);
                // $posts  =   $contents["data"];
                // dd("access", $posts);
                // $response = generateResponse($posts, true, '', [], 'object');
                // return response($response);
            } else {

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=' . $token,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Cookie: csrftoken=nbzgGORrhZbxiygaMAzChnZWWQWnF5WX; ig_did=C37F3331-07D6-4343-9699-1A080395FE5A; ig_nrcb=1; mid=Yn32TAAEAAHsoru7zk_pB1caueDF'
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                echo $response;

                $refresh_access_token_response = json_decode($response);

                $refresh_access_token = $refresh_access_token_response->access_token;
                if ($refresh_access_token) {
                    $update =  Setting::where('name', 'long_lived_access_token_instagram')->update([
                        'value' => $refresh_access_token,
                    ]);
                }
                // Fetch Media Instagram
                $fields = "media_url,permalink";
                $token = $refresh_access_token;
                $limit = 20;

                $json_feed_url = "https://graph.instagram.com/me/media?fields={$fields}&access_token={$token}&limit={$limit}";
                $json_feed = @file_get_contents($json_feed_url);

                $contents = json_decode($json_feed, true, 512, JSON_BIGINT_AS_STRING);

                $posts  =   $contents["data"];

                $response = generateResponse($posts, true, '', [], 'object');
                return response($response);
            }
        } else {


            //   Get a access token
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.instagram.com/oauth/access_token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('client_id' => $instagram_app_id, 'client_secret' => $instagram_app_secret, 'grant_type' => 'authorization_code', 'redirect_uri' => 'https://demo.multivendor.nictusthemes.com/auth/', 'code' => $instagram_app_code),
                CURLOPT_HTTPHEADER => array(
                    'Cookie: csrftoken=nbzgGORrhZbxiygaMAzChnZWWQWnF5WX; ig_did=C37F3331-07D6-4343-9699-1A080395FE5A; ig_nrcb=1; mid=Yn32TAAEAAHsoru7zk_pB1caueDF'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $result = json_decode($response);


            $access_token = $result->access_token;

            /*To access long lived token*/
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret=' . $instagram_app_secret . '&access_token=' . $access_token,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: csrftoken=nbzgGORrhZbxiygaMAzChnZWWQWnF5WX; ig_did=C37F3331-07D6-4343-9699-1A080395FE5A; ig_nrcb=1; mid=Yn32TAAEAAHsoru7zk_pB1caueDF'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $long_lived_access_token_response = json_decode($response);

            $long_lived_access_token = $long_lived_access_token_response->access_token;

            if ($long_lived_access_token) {

                $create =  Setting::create([
                    'name' => 'long_lived_access_token_instagram',
                    'value' => $long_lived_access_token,
                    'is_specific' => 0
                ]);
            }
            // Fetch Media Instagram
            $fields = "media_url,permalink";
            $token = $long_lived_access_token;
            $limit = 20;
            // new code starts


            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.instagram.com/me/media?fields=' . $fields . '&access_token=' . $token . '&limit=' . $limit,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: csrftoken=nbzgGORrhZbxiygaMAzChnZWWQWnF5WX; ig_did=C37F3331-07D6-4343-9699-1A080395FE5A; ig_nrcb=1; mid=Yn32TAAEAAHsoru7zk_pB1caueDF'
                ),
            ));

            $response = curl_exec($curl);


            curl_close($curl);
            // echo $response;
            return response($response);
            // new code ends

            // $json_feed_url = "https://graph.instagram.com/me/media?fields={$fields}&access_token={$token}&limit={$limit}";
            // $json_feed = @file_get_contents($json_feed_url);
            // $contents = json_decode($json_feed, true, 512, JSON_BIGINT_AS_STRING);

            // $posts  =   $contents["data"];

            // $response = generateResponse($posts, true, '', [], 'object');
            // return response($response);
        }
    }
}
