<?php

namespace fw_micro\core;

use fw_micro\db\Config;
use fw_micro\interfaces\Bootstrap;
use fw_micro\pattern\CoR\AbstractHandler;
use fw_micro\pattern\Register\Register;

/**
 * Class InitDB
 * @package fw_micro\core
 */
class InitDB extends AbstractHandler implements Bootstrap
{
    /**
     * @var Config
     */
    public $config;

    /**
     * @inheritDoc
     */
    public function exec($request): bool
    {
        Register::get()->db = $this->config->create();
        return true;
    }
}
