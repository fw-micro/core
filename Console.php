<?php

namespace fw_micro\core;

use fw_micro\pattern\Register\Register;
use Symfony\Component\Console\Application;

/**
 * Class Console
 * @package fw_micro\core
 */
class Console
{
    use GetBootstrap;

    /**
     * @param array $config
     * @throws \Exception
     */
    public function run(array $config): void
    {
        Register::get()->config = $config;
        if (!$this->getBootstrap($config)->run($config)) {
            throw new \Exception('bad loader');
        }
        $app = new Application();

        foreach ($config['controllers'] ?? [] as $controller) {
            $app->add(new $controller());
        }

        $app->run();
    }
}
