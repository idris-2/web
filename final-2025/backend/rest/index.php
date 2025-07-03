<?php

require "../vendor/autoload.php";
require "./services/ExamService.php";

Flight::register('examService', 'ExamService');

require 'routes/ExamRoutes.php';

Flight::route('/', function () {
    echo "Hello, FlightPHP!";
});

Flight::start();
 ?>
