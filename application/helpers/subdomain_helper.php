<?php
function get_subdomain() {
    $host = $_SERVER['HTTP_HOST']; // e.g. chilihut.fooyes.co.uk
    $parts = explode('.', $host);

    if(count($parts) <= 2){
        return $parts[0];
    }
    // For domains like chilihut.fooyes.co.uk
    if (count($parts)) {
        return $parts[1]; // 'chilihut'
    }

    return null; 
}