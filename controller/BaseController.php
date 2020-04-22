<?php

namespace fw_micro\core\controller;

use fw_micro\core\response\Response;
use fw_micro\pattern\Register\Register;

/**
 * Class BaseController
 * @package fw_micro\core\controller
 */
class BaseController
{
    protected $layout;

    public function __construct()
    {
        $accessList = $this->accessList ?? ['*' => ['*']];
        if (!$this->checkAccess($accessList)) {
            $response = new Response();
            $response->setHeader('HTTP/1.1 403 Forbidden');
            $response->print();
            die;
        }
        $this->init();
    }

    public function init()
    {
    }

    public function getUserGroup()
    {
        return '*';
    }

    public function checkAccess(array $accessList)
    {
        if (in_array('*', $accessList['*'] ?? [])) {
            return true;
        }

        $group = $this->getUserGroup();
        if (!is_array($accessList[$group])) {
            return false;
        }

        $list = $accessList[$group];
        $default = $list['default'] ?? null;
        $action = Register::get()->request['action'];

        if (in_array($action, $list['allow'])) {
            return true;
        }

        if ($default) {
            $this->redirect($default)->print();
            die;
        }

        return false;
    }

    /**
     * @param string $file
     * @param array $options
     * @return Response
     */
    public function render(string $file, array $options): Response
    {
        extract($options);
        $response = new Response();
        ob_start();
        require $file;
        $content = ob_get_clean();
        if ($this->layout) {
            ob_start();
            require $this->layout;
            $html = ob_get_clean();
        } else {
            $html = $content;
        }
        $response->setBody($html);
        return $response;
    }

    public function redirect(string $url): Response
    {
        return (new Response())->setHeader('Location: ' . $url);
    }

    public function renderJson(array $data): Response
    {
        return (new Response())
            ->setBody(json_encode($data))
            ->setHeader('Content-Type: application/json');
    }
}
