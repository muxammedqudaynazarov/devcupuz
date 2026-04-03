<?php
require 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = escape_data($_POST["api_key"]);

    if ($api_key == PROJECT_API_KEY) {
        $temperature = escape_data($_POST["temperature"]);
        $humidity = escape_data($_POST["humidity"]);
        $gas = escape_data($_POST["gas"]);
        $soil = escape_data($_POST["soil"]);


        $sql = "INSERT INTO tbl_temperature(`temperature`, `humidity`, `gas`, `soil`, `created_date`)
			VALUES('" . $temperature . "','" . $humidity . "','" . $gas . "','" . $soil . "','" . date("Y-m-d H:i:s") . "')";

        if ($db->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
        echo "OK. INSERT ID: ";
        echo $db->insert_id;
    } else         echo "Wrong API Key";
} else {
    echo "No HTTP POST request found";
}

function escape_data($data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}
