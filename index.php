
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

if(isset($_POST['phone']) && ($_POST['phone'] != "")) {

    $number = $_POST['phone'];

    $info = \MSISDN\Lookup::msisdn($number);

    if (!empty($info['error'])) {
        echo "<p>";
        echo 'Number: ' . $number . "<br>";
        echo 'Error:' . $info['error'];
        echo "</p>";
    }else {
        echo "<p>";
        echo 'Number: ' . $number . "<br>";
        echo "</p><p>";
        echo 'Code: ' . $info['code'] . "<br>";
        echo 'Location: ' . $info['country'] . "<br>";
        echo 'Region: ' . $info['isoCountry'] . "<br>";
        echo "</p>";
        if (empty($info['error1'])) {
            echo "<p>";
            echo 'NDC: ' . $info['NDC'] . "<br>";
            echo 'Network: ' . $info['Network'] . "<br>";
            echo 'Operator: ' . $info['Operator'] . "<br>";
            echo "</p>";
            echo "</p><p>";
            echo 'Subscriber Number: ' . $info['Subscribe'] . "<br>";
            echo "</p>";
        }else {
            echo "<p>";
            echo 'Error:' . $info['error1'];
            echo "</p>";  
        }
    }
}
?>
</body>
</html>