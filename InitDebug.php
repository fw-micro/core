<?php

namespace fw_micro\core;

use fw_micro\interfaces\Bootstrap;
use fw_micro\pattern\CoR\AbstractHandler;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\DebugClassLoader;

/**
 * Class InitDebug
 * @package fw_micro\core
 */
class InitDebug extends AbstractHandler implements Bootstrap
{
    /**
     * @inheritDoc
     */
    public function exec($request): bool
    {
        Debug::enable();
        DebugClassLoader::enable();
        ErrorHandler::register();
        ExceptionHandler::register();
        return true;
    }
}
