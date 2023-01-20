<?php

namespace Physler\Controller\Api;

class StatusController extends BaseController {
    public function _main()
    {
        sleep(2);
        $this->outputJson([
            "online" => true
        ]);
    }
}