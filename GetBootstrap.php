<?php

namespace fw_micro\core;

use fw_micro\interfaces\Bootstrap;

/**
 * Trait GetBootstrap
 * @package fw_micro\core
 */
trait GetBootstrap
{
    /**
     * @param array $config
     * @return Bootstrap|mixed|null
     * @throws \Exception
     */
    private function getBootstrap(array $config)
    {
        $bootstrap = $config['bootstrap'] ?? [];
        if (!is_array($bootstrap)) {
            throw new \Exception('Don\'t have bootstrap');
        }

        $runner = null;
        $tmp = null;
        foreach ($bootstrap as $name => $className) {
            if (is_array($className)) {
                $class = (new ResolveBootstrap())->getClass($className);
            } else {
                $class = new $className();
            }
            /** @var Bootstrap $class */
            /** @var Bootstrap $tmp */
            if (!($class instanceof Bootstrap)) {
                throw new \Exception($className . ' not implement bootstrap');
            }

            if ($runner === null) {
                $runner = $class;
                $tmp = $class;
            } else {
                $tmp = $tmp->setNext($class);
            }
        }

        return $runner;
    }
}
