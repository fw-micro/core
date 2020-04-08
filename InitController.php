<?php

namespace fw_micro\core;

use fw_micro\interfaces\Bootstrap;
use fw_micro\pattern\CoR\AbstractHandler;
use fw_micro\pattern\Register\Register;

/**
 * Class InitController
 * @package fw_micro\core
 */
class InitController extends AbstractHandler implements Bootstrap
{
    /**
     * @inheritDoc
     */
    public function exec($request): bool
    {
        $config = $request['controllers'] ?? [];
        $controller = Register::get()->controller;
        $action = Register::get()->action;

        $className = $config[$controller] ?? null;
        if ($className === null) {
            if ($this->getLogger()) {
                $this->getLogger()->error($controller . ' not found');
            }
            return false;
        }

        $class = new $className();
        $response = $class->{$action}();
        Register::get()->response = $response;
        return true;
    }
}
