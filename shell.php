<?php
include "App/Lookup.php";

if (isset($argv[1])) {
    $number = $argv[1];

    $lookup = new \App\Lookup();
    $info = $lookup->msisdn($number);

    $labels = array(
        "number" => "Search: ",
        "numberDetail" => "Number: ",
        "country_code" => "Country code: ",
        "ndc" => "NDC: ",
        "country" => "Country: ",
        "ISO" => "Region: ",
        "network" => "Network: ",
        "Subscribe" => "Subscriber Number: ",
        "error" => "Error: "
     );


    echo "\nMSISDN Lookup\n\n";

    foreach ($labels as $key => $value) {
        if (isset($info[$key])) {
            echo $value . $info[$key] . "\n";
        }
    }

    echo "\nBye bye\n";
}
