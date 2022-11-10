<?php

namespace Physler\Controller\Api;

class StatusController extends BaseController {
    public function _main()
    {
        $this->outputJson([
            "online" => true
        ]);
    }
}