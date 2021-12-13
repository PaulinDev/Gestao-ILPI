<?php

function shortName(string $userName){
    $name = explode(" ", $userName);
    if (count($name) > 1) {
        return $name[0] . ' ' . $name[1];
    } else {
        return $name[0];
    }
}
