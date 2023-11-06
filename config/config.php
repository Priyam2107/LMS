<?php

session_start();

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    define("BASE_URL", "http://localhost/library%20management/LMS/");
    define("DIR_URL", $_SERVER['DOCUMENT_ROOT'] . "/library management/LMS/");

    define("SERVER_NAME", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "");
    define("DATABASE", "lms");
} else {
    define("BASE_URL", "https://lms.com");
    define("DIR_URL", $_SERVER['DOCUMENT_ROOT']);

    define("SERVER_NAME","");
    define("USERNAME","");
    define("PASSWORD","");
    define("DATABASE","");
}
