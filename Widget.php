<?php

namespace fw_micro\core;

use fw_micro\core\controller\Render;
use fw_micro\pattern\BaseObject;

/**
 * Class Widget
 * @package fw_micro\core
 */
abstract class Widget extends BaseObject
{
    use Render;

    protected $layout;

    /**
     * @param array $config
     * @return string
     */
    abstract public function begin(array $config = []): string;
}
