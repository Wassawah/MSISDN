<?php
include "App/Lookup.php";

if (isset($argv[1])) {
    $number = $argv[1];
    $info = \App\Lookup::msisdn($number);

    echo "\nMSISDN Lookup\n\n";
    if (!empty($info['country_code'])) {
        echo "Number: " . $info['number'] . "\n";
        echo "Country: " . $info['country'] . "\n";        
        echo "Country code: " . $info['country_code'] . "\n";
        echo "Region: " . $info['ISO'] . "\n\n";
    } 
    if (!empty($info['ndc'])) {
        echo "NDC: " . $info['ndc'] . "\n";
        echo "Network: " . $info['network'] . "\n";
        echo "Subscriber Number: " . $info['Subscribe'] . "\n\n";
    } else {
        echo "ERROR:" . $info['error'];
    }
    echo "\n";
}
