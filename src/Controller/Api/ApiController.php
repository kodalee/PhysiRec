<?php

namespace Physler\Controller\Api;

class ApiController extends BaseController {
    public function getResource() {
        $segments = $this->getSegments();
        switch ((ISSET($segments[2]) ? $segments[2] : "")) {
            case 'gauth':
                return new GAuthController();
            case 'app':
                return new AppController();
            case 'status':
                return new StatusController();
            case 'render':
                return new RenderController();
            default:
                $this->__call($segments, []);
                break;
        }
    }
}