<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>Phone lookup</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<p>Enter phone number (+386 40 578124 or 386 40 578124)</p>
<p>MSISDN = Country Code + National Destination Code + Subscriber Number</p>
<form action="index.php" method="post">
    Phone number: <input type="text" name="phone"><br>
    <input type="submit" value="Submit">
</form>

<?php
include "App/Lookup.php";

if (isset($_POST['phone']) && ($_POST['phone'] != "")) {
    $number = $_POST['phone'];

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


    echo "<h2>MSISDN Lookup</h2>";

    foreach ($labels as $key => $value) {
        if (isset($info[$key])) {
            echo "<div>" . $value . $info[$key] . "</div>";
        }
    }
}
?>
</body>
</html>