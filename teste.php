<?php
    $temperature = $_POST["temperature"];
    $write = "<p>Teplota: ".$temperature."</p>";
    file_put_contents("teplota.php", $write);
?>