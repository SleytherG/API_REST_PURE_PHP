<?php

require_once __DIR__ . '/../src/Core/Router.php';
require_once __DIR__ . '/../src/Controllers/PatientController.php';
require_once __DIR__ . '/../src/Util/HttpResponses.php';

allowCors();

$router = new Router();
$router -> registerController(PatientController::class);

HttpResponses::init();

$router -> dispatch();
