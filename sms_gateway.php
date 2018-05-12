<?php
require_once 'vendor/autoload.php';

//get_messages();

function get_messages()
{

// The router class is the main entry point for interaction.
    $router = new if0xx\HuaweiHilinkApi\Router;

// if specified without http or https, assumes http://
    $router->setAddress('192.168.8.1');

// Username and password.
    // Username is always admin as far as I can tell, default password is admin as well.
    $router->login('admin', 'admin');

//var_dump($router->getInbox());
    //var_dump($router->getNetwork());
    $sms_array = $router->getInbox();

    //print_r($sms_array);
    foreach ($sms_array as $msgs) {
        foreach ($msgs as $msg) {

            $post_data = array();
            $num = $msg->Phone;

            $index = $msg->Index;

            $string = (string) $num;

            $post_data['from'] = $string;

            $txt = $msg->Content;
            $str = (string) $txt;

            $post_data['message'] = $str;

            //echo gettype($num);
            $data = json_encode($post_data);

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_PORT => "3007",
                CURLOPT_URL => "http://52.178.24.227:3007/labresults/sms",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/json",
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
                $router->deleteSms($index);
            }
        }
    }
}

function sendmessage($a, $b)
{
// The router class is the main entry point for interaction.
    $router = new if0xx\HuaweiHilinkApi\Router;

// if specified without http or https, assumes http://
    $router->setAddress('192.168.8.1');

// Username and password.
    // Username is always admin as far as I can tell, default password is admin as well.
    $router->login('admin', 'admin');

    $router->sendSms($a, $b);
}
