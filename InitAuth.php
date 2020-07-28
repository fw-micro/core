<?php

namespace fw_micro\core;

use fw_micro\core\auth\AuthInterface;
use fw_micro\interfaces\Bootstrap;
use fw_micro\pattern\CoR\AbstractHandler;
use fw_micro\pattern\Register\Register;

/**
 * Class InitAuth
 * @package fw_micro\core
 */
class InitAuth extends AbstractHandler implements Bootstrap
{
    /**
     * @param $request
     * @return bool
     */
    public function exec($request): bool
    {
        $auth = new $request['auth']($request['config']);
        if ($auth instanceof AuthInterface) {
            Register::get()->auth = $auth;
            return true;
        }
        return false;
    }
}
