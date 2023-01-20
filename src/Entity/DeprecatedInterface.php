<?php

namespace Physler\Entity;

abstract class DeprecatedInterface {
    function __construct()
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated', E_USER_DEPRECATED);
    }
}