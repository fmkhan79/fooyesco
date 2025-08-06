<?php
function get_subdomain() {
    $host = $_SERVER['HTTP_HOST']; // e.g. chilihut.fooyes.co.uk
    $parts = explode('.', $host);

    // For domains like chilihut.fooyes.co.uk
    if (count($parts) >= 3) {
        return $parts[0]; // 'chilihut'
    }

    return null; // No subdomain
}