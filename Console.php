<?php

namespace fw_micro\core;

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
