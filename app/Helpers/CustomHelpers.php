<?php
if (!function_exists('sendDateToVNPT')) {
    function sendDataToVNPT($servicesLink, $dataXML) {
        $client = new \GuzzleHttp\Client();;
        $response = $client->post($servicesLink, [
            'headers' => [
                'Content-Type' => 'application/soap+xml; charset=utf-8',
                'Content-Length' => strlen($dataXML),
            ],
            'body' => $dataXML,
        ]);
        $statusCode = $response->getStatusCode();
        $responseContent = $response->getBody()->getContents();
        if ($statusCode == 200) {
            return $responseContent;
        } else {
            return 500;
        }
    }
}
if (!function_exists('createFkey')) {
    function createFkey() {
        $now = now();
        $seconds = $now->second;
        $minutes = $now->minute;
        $hours = $now->hour;
        $day = $now->day;
        $month = $now->month;
        $year = $now->year;
        $randomNumber = mt_rand(100, 999);
        $fkey = "FKT$seconds$minutes$hours"."D$day$month$year"."RD$randomNumber";
        return $fkey;
    }
}
if (!function_exists('getDataFromResponseVNPT')) {
    function getDataFromResponseVNPT($responseVNPT, $xmlNode) {
        $xml = new DOMDocument();
        $xml->loadXML($responseVNPT);
        $ImportAndPublishInvResult = $xml->getElementsByTagName($xmlNode)->item(0);
        if($ImportAndPublishInvResult){
            $response = $ImportAndPublishInvResult->textContent;
            return $response;
        }else{
            return null;
        }
    }
}
if (!function_exists('XMLToArray')) {
    function XMLToArray($xmlString) {
        $xml = simplexml_load_string($xmlString);
        $json = json_encode($xml);
        $array = json_decode($json, true);
        return $array;
    }
}

if (!function_exists('getNoFromResponseVNPT')) {
    function getNoFromResponseVNPT($responseVNPT, $xmlNode) {
        $xml = new DOMDocument();
        $xml->loadXML($responseVNPT);
        $ImportAndPublishInvResult = $xml->getElementsByTagName($xmlNode)->item(0);
        $response = $ImportAndPublishInvResult->textContent;
        $parts = explode("_", $response);
        if (isset($parts[1])) {
            return $parts[1];
        }else{
            return null;
        }
    }
}
if (!function_exists('getNoFromResponseVNPTNew')) {
    function getNoFromResponseVNPTNew($responseVNPT, $xmlNode) {
        $xml = new DOMDocument();
        $xml->loadXML($responseVNPT);
        $ImportAndPublishInvResult = $xml->getElementsByTagName($xmlNode)->item(0);
        $response = $ImportAndPublishInvResult->textContent;
        $parts = explode(";", $response);
        if (isset($parts[2])) {
            return $parts[2];
        }else{
            return null;
        }
    }
}
if (!function_exists('getERRFromVNPT')) {
    function getERRFromVNPT($responseVNPT, $xmlNode) {
        $xml = new DOMDocument();
        $xml->loadXML($responseVNPT);
        $ImportAndPublishInvResult = $xml->getElementsByTagName($xmlNode)->item(0);
        $response = $ImportAndPublishInvResult->textContent;
        $parts = explode(":", $response);
        if (isset($parts[1])) {
            return $parts[1];
        }else{
            return null;
        }
    }
}
if (!function_exists('numberToWords')) {
    function numberToWords($number) {
        if($number == 10000){
            return "Mười Nghìn";
        }else{
            $ones = array(
                0 => 'Không',
                1 => 'Một',
                2 => 'Hai',
                3 => 'Ba',
                4 => 'Bốn',
                5 => 'Năm',
                6 => 'Sáu',
                7 => 'Bảy',
                8 => 'Tám',
                9 => 'Chín'
            );
        
            $teens = array(
                11 => 'Mười Một',
                12 => 'Mười Hai',
                13 => 'Mười Ba',
                14 => 'Mười Bốn',
                15 => 'Mười Năm',
                16 => 'Mười Sáu',
                17 => 'Mười Bảy',
                18 => 'Mười Tám',
                19 => 'Mười Chín'
            );
        
            $tens = array(
                10 => 'Mười',
                20 => 'Hai Mươi',
                30 => 'Ba Mươi',
                40 => 'Bốn Mươi',
                50 => 'Năm Mươi',
                60 => 'Sáu Mươi',
                70 => 'Bảy Mươi',
                80 => 'Tám Mươi',
                90 => 'Chín Mươi'
            );
        
            $number = (int)$number;
        
            if ($number == 0) {
                return $ones[0];
            }
        
            $words = array();
        
            if ($number < 0) {
                $words[] = 'Âm';
                $number = abs($number);
            }
        
            if ($number >= 1000000) {
                $millions = floor($number / 1000000);
                $words[] = numberToWords($millions) . ' Triệu';
                $number %= 1000000;
            }
        
            if ($number >= 1000) {
                $thousands = floor($number / 1000);
                $words[] = numberToWords($thousands) . ' Nghìn';
                $number %= 1000;
            }
        
            if ($number >= 100) {
                $hundreds = floor($number / 100);
                $words[] = numberToWords($hundreds) . ' Trăm';
                $number %= 100;
            }
        
            if ($number > 0) {
                if (count($words) > 0) {
                    $words[] = '';
                }
        
                if ($number < 10) {
                    $words[] = $ones[$number];
                } elseif ($number < 20) {
                    $words[] = $teens[$number];
                } else {
                    $ten = floor($number / 10) * 10;
                    $one = $number % 10;
                    $words[] = $tens[$ten];
                    if ($one > 0) {
                        $words[] = $ones[$one];
                    }
                }
            }
        
            return implode(' ', $words);
        }
    }
}

if (!function_exists('getToDay')) {
    function getToDay() {
        return now()->format('Y-m-d H:i:s');
    }
}
if (!function_exists('isBase64')) {
    function isBase64($data) {
        $decodedData = base64_decode($data, true);
        return ($decodedData !== false);
    }
}
if (!function_exists('unformatCurrency')) {
    function unformatCurrency($formattedPrice) {
        $unformattedPrice = (float) str_replace(',', '', $formattedPrice);
        return $unformattedPrice;
    }
}