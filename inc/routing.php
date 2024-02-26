<?php

function isRoute(string $method, string $route, array ...$handlers): int
{
    global $params;
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
    $route_rgx = preg_replace('#:(\w+)#','(?<$1>(\S+))', $route);
    return preg_match("#^$route_rgx$#", $uri, $params) && $method == $_SERVER['REQUEST_METHOD'];
}
