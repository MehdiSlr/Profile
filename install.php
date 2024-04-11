<?php

require_once __DIR__."/conf/serv_conf.php";

if (isset($conn) && $conn instanceof mysqli) {
    $sql = file_get_contents(__DIR__.'/pros.sql');

    if (mysqli_multi_query($conn, $sql)) {
        echo "Installation was successfully!";
    }
    else {
        echo "Error while installation: ". mysqli_error($conn);
    }
    mysqli_close($conn);
}