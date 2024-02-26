<?php

// dump and die
function dd($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    die;
}

// dump
function dump($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
}

// jsonify output
function json(mixed $data)
{
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
}

function callControllerMethod($controller, $method) {
    return (new $controller)->$method();
}