<?php

function debug($data, $exit = false) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";

    if ($exit) {
        exit;
    }
}

?>