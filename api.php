<?php

require(__DIR__ . "/src/Bootstrapper.php");

use Phylser\Controller\Api\ApiController;

$apiController = new ApiController();
$apiController->getResource("gauth")->InitAction();
