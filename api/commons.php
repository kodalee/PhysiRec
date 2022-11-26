<?php
define("__ROOTROOT__", $_SERVER["DOCUMENT_ROOT"]);
require(__ROOTROOT__ . "/src/Bootstrapper.php");

Physler\Controller\Api\ApiController::Task();