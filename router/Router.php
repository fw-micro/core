<?php

namespace fw_micro\core\router;

use fw_micro\interfaces\Bootstrap;
use fw_micro\pattern\CoR\AbstractHandler;
use fw_micro\pattern\Register\Register;
use Nette\Http\Request;
use Nette\Http\UrlScript;
use Nette\Routing\Route;
use Nette\Routing\RouteList;

/**
 * Class Router
 * @package fw_micro\core\router
 */
class Router extends AbstractHandler implements Bootstrap
{

    /**
     * @inheritDoc
     */
    public function exec($request): bool
    {
        $router = $request['router'];
        $rList = new RouteList();

        foreach ($router as $key => $value) {
            if (is_array($value)) {
                $rList->add(new Route($key, $value));
            } else {
                $rList->add(new Route($value));
            }
        }

        $match = $rList->match(new Request(new UrlScript($_SERVER['REQUEST_URI']), $_POST, null, $_COOKIE));

        if (is_array($match)) {
            Register::get()->controller = $match['controller'];
            Register::get()->action = $match['action'] ?? 'index';
            Register::get()->request = $match;
        } else {
            if ($this->getLogger()) {
                $this->getLogger()->error('no match');
            }
            return false;
        }

        return true;
    }
}
