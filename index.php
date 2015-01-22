
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

    $info = \App\Lookup::msisdn($number);

    echo "<p>";
    echo 'Number: ' . $info['number'] . "<br>";
    echo "</p><p>";
    if (!empty($info['country_code'])) {
        echo 'Country code: ' . $info['country_code'] . "<br>";
        echo 'Location: ' . $info['country'] . "<br>";
        echo 'Region: ' . strtoupper($info['ISO']) . "<br>";
        echo "</p>";
    }
    if (!empty($info['ndc'])) {
        echo "<p>";
        echo 'NDC: ' . $info['ndc'] . "<br>";
        echo 'Network: ' . $info['network'] . "<br>";
        echo "</p>";
        echo "</p><p>";
        echo 'Subscriber Number: ' . $info['Subscribe'] . "<br>";
        echo "</p>";
    } else {
        echo "<p>";
        echo 'Error:' . $info['error'];
        echo "</p>";
    }
}
?>
</body>
</html>