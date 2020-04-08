<?php

namespace fw_micro\core;

/**
 * Class ResolveBootstrap
 * @package fw_micro\core
 */
class ResolveBootstrap
{
    /**
     * @param array $config
     * @return mixed
     */
    public function getClass(array $config)
    {
        $class = $config['class'];
        unset($config['class']);
        return new $class($config);
    }
}
