<?php

namespace fw_micro\core;

use fw_micro\core\response\ResponseInterface;
use fw_micro\interfaces\Bootstrap;
use fw_micro\pattern\CoR\AbstractHandler;
use fw_micro\pattern\Register\Register;

/**
 * Class InitResponse
 * @package fw_micro\core
 */
class InitResponse extends AbstractHandler implements Bootstrap
{
    public $response;

    /**
     * @inheritDoc
     */
    public function exec($request): bool
    {
        if (!(Register::get()->response instanceof $this->response)) {
            return false;
        }

        echo Register::get()->response->print();
        return true;
    }
}
