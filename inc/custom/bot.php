<?php

function bot($message, $url)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"content\": \"$message\"}",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Cookie: __cfduid=d5f1a47b65ad6e5eae8714df12c304b661597580155; __cfruid=f0077b70b216ca6a35ad1f5280ecec475e2dd4cc-1597580155"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
