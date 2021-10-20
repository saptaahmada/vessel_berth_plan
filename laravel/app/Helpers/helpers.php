<?php

function safeEncrypt($message, $key)
{
    return openssl_encrypt($message,"AES-128-ECB",$key);
}

function safeDecrypt($encrypted, $key)
{
    return openssl_decrypt($encrypted,"AES-128-ECB", $key);
}

function send_wa($hp, $text)
{
    ini_set("soap.wsdl_cache_enabled", "0");
    $url = "http://sittl.teluklamong.co.id/wsouth.asmx?wsdl";
    $client = new SoapClient($url);
    $p = $client->kirim_WA([
        "xUser"=>"raka",
        "xpassword"=>"rakar",
        "Xidapp"    => "42",
        "xNoHP"=> $hp,
        "xText"=> $text,
    ]);

    $response=$p->kirim_WAResult;

    return $response;
    // return true;
}

function sendCurlBasicAuth($url, $auth="ttl:pelindottl", $data)
{
    // $url = 'https://vasa.api.pelindo.co.id/ttl/ship-departure-estimation';
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD,  $auth);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $output = curl_exec($ch); 
    $obj = json_decode($output, true);
    curl_close($ch);

    return $obj;

    // echo json_encode($obj);
}

function getDefaultDate($date)
{
    $arrDate = explode(' ', $date);
    $arrTgl = explode('/', $arrDate[0]);
    $arrTime = explode(':', $arrDate[1]);

    return "{$arrTgl[2]}-{$arrTgl[1]}-{$arrTgl[0]} {$arrTime[0]}:{$arrTime[1]}";
}