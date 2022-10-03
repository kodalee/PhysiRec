<?php

namespace Phylser\Controller\Api;

class ApiController extends BaseController {
    public function getResource() {
        $segments = $this->getUriSegments();
        switch ($segments[2]) {
            case 'gauth':
                return new GAuthController();
            default:
                $this->__call($segments, []);
                break;
        }
    }
}