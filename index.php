<?php

/**
 *
 * Create API in PHP
    * Create API to Fetch Data from database in php mysql
    * create API to Insert/Store data in php mysql
    * create API to fetch single record mysql
    * create API to update data from mysql
    * Create API to delete from mysql
 *
 */


// Configs
define('APP_ROOT', __DIR__);
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'local');

require_once 'inc/bootstrap.php';

$db = new database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$db->init();

// match routing
(match(1) {
    isRoute('GET', '/') => function () {
      json(['msg' => 'Hello!']);
    },

    isRoute('GET', '/api/contacts'), isRoute('GET', '/api/contacts/') => function() {
        (new contacts)->list();
    },

    isRoute('POST', '/api/contacts'), isRoute('POST', '/api/contacts/') => function() {
        (new contacts)->store($_REQUEST);
    },

    isRoute('POST', '/api/contacts/:id') => function() {
        global $params, $db;
        (new contacts)->update($db->sanitize($params['id']), $_REQUEST);
    },

    isRoute('GET', '/api/contacts/:id'), isRoute('GET', '/api/contacts/:id/') => function () {
        global $params, $db;
        (new contacts)->show($db->sanitize($params['id']));
    },

    isRoute('DELETE', '/api/contacts/:id') => function () {
        global $params, $db;
       (new contacts)->delete($db->sanitize($params['id']));
    },
    default => function() {
        http_response_code(405);
        json(['err' => 'Route not found!']);
    }
})();