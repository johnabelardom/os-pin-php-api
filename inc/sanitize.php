<?php

function sanitizeAllowed(array $data, array $allowedKeys) {
    global $db;
    $sanitized = [];

    foreach ($data as $k => $value) {
        if (in_array($k, $allowedKeys))
            $sanitized[$k] = $db->sanitize($value);
    }

    return $sanitized;
}

