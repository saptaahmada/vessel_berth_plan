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

function send_wa_link($no_hp, $text, $idapp)
{
    ini_set("soap.wsdl_cache_enabled", "0");
    $url = "http://sittl.teluklamong.co.id/wsouth.asmx?wsdl";
    $client=new SoapClient($url);
    $p = $client->kirim_WA_link([
        "xUser" => "raka",
        "xpassword" => "rakar",
        "Xidapp" => $idapp,
        "xNoHP" => $no_hp,
        "xText" => $text,
    ]);

    $response=$p->kirim_WA_linkResult;
    return true;
}

function send_wa_file($no_hp, $text, $file, $idapp)
{
    ini_set("soap.wsdl_cache_enabled", "0");
    $url = "http://sittl.teluklamong.co.id/wsouth.asmx?wsdl";
    $client=new SoapClient($url);
    $p = $client->kirim_WA_file([
        "xUser" => "raka",
        "xpassword" => "rakar",
        "Qidapp" => $idapp,
        "xNoHP" => $no_hp,
        "xText" => $text,
        "xfile" => $file,
    ]);

    $response=$p->kirim_WA_fileResult;
    return true;
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

function getDefaultDate($date, $is_excel=false)
{
    $arrDate = explode(' ', $date);
    if(count($arrDate) > 1) {
        $arrTgl = explode('/', $arrDate[0]);
        $arrTime = explode(':', $arrDate[1]);
        if(!$is_excel)
            return "{$arrTgl[2]}-{$arrTgl[1]}-{$arrTgl[0]} {$arrTime[0]}:{$arrTime[1]}";
        else
            return "{$arrTgl[2]}-{$arrTgl[0]}-{$arrTgl[1]} {$arrTime[0]}:{$arrTime[1]}";
    } else {
        $arrTgl = explode('/', $arrDate[0]);
        if(!$is_excel)
            return "{$arrTgl[2]}-{$arrTgl[1]}-{$arrTgl[0]}";
        else 
            return "{$arrTgl[2]}-{$arrTgl[0]}-{$arrTgl[1]}";
    }
}

function getMonthName($month, $country = 'INDONESIA')
{
    $month_name = "";

    if($country == 'INDONESIA') {
        switch ($month) {
            case '1': $month_name = 'JANUARI'; break;
            case '2': $month_name = 'FEBRUARI'; break;
            case '3': $month_name = 'MARET'; break;
            case '4': $month_name = 'APRIL'; break;
            case '5': $month_name = 'MEI'; break;
            case '6': $month_name = 'JUNI'; break;
            case '7': $month_name = 'JULI'; break;
            case '8': $month_name = 'AGUSTUS'; break;
            case '9': $month_name = 'SEPTEMBER'; break;
            case '10': $month_name = 'OKTOBER'; break;
            case '11': $month_name = 'NOVEMBER'; break;
            case '12': $month_name = 'DESEMBER'; break;
            default:
                break;
        }
    }

    return $month_name;
}


function getSheet($location)
{
    $excelreader    = new PHPExcel_Reader_Excel2007();
    $loadexcel      = $excelreader->load($location);
    $sheet          = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
    return $sheet;
}