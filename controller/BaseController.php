<?php

namespace fw_micro\core\controller;

use fw_micro\core\response\Response;

/**
 * Class BaseController
 * @package fw_micro\core\controller
 */
class BaseController
{
    protected $layout;

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
}
