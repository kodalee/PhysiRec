<?php

require(__DIR__ . "/src/Bootstrapper.php");

use Physler\Controller\Api\ApiController;

$apiController = new ApiController();
$apiController->getResource()->InitAction();
