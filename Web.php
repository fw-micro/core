<?php

namespace fw_micro\core;

use fw_micro\interfaces\Bootstrap;
use fw_micro\pattern\Register\Register;

/**
 * Class Web
 * @package fw_micro\core
 */
class Web
{
    use GetBootstrap;

    /**
     * @param array $config
     * @throws \Exception
     */
    public function run(array $config): void
    {
        Register::get()->config = $config;
        $runner = $this->getBootstrap($config);

        $statusRunner = $runner->run($config);
        if (!$statusRunner) {
            throw new \Exception('Page not found', 404);
        }
    }
}