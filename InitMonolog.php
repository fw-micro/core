<?php

namespace fw_micro\core;

use fw_micro\interfaces\Bootstrap;
use fw_micro\pattern\CoR\AbstractHandler;
use fw_micro\pattern\Register\Register;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class InitMonolog
 * @package fw_micro\core
 */
class InitMonolog extends AbstractHandler implements Bootstrap
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $file;

    /**
     * @var integer
     */
    public $level;

    /**
     * @inheritDoc
     */
    public function exec($request): bool
    {
        $logger = new Logger($this->name);
        $logger->pushHandler(new StreamHandler($this->file, $this->level));
        Register::get()->logger = $logger;
        Register::get()->setLog($logger);
        return true;
    }
}
