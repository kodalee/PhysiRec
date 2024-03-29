<?php

namespace Physler\Controller\Api;

class ApiController extends BaseController {
    public static function Task() {
        return (new ApiController())->getResource()->InitAction();
    }

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
            case 'user':
                return new UserController();
            default:
                $this->__call($segments, []);
                break;
        }
    }
}