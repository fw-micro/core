<?php

namespace fw_micro\core\response;

/**
 * Class Response
 * @package fw_micro\core\response
 */
class Response implements ResponseInterface
{
    /**
     * @var string
     */
    private $html;

    /**
     * @var array
     */
    private $cookie = [];

    /**
     * @var array
     */
    private $session = [];

    /**
     * @var array
     */
    private $header = [];

    /**
     * @param string $html
     * @return ResponseInterface
     */
    public function setBody(string $html): ResponseInterface
    {
        $this->html = $html;
        return $this;
    }

    /**
     * @param string $header
     * @return ResponseInterface
     */
    public function setHeader(string $header): ResponseInterface
    {
        $this->header[] = $header;
        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return ResponseInterface
     */
    public function setCookie(string $key, $value): ResponseInterface
    {
        $this->cookie[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return ResponseInterface
     */
    public function setSession(string $key, $value): ResponseInterface
    {
        $this->session[$key] = $value;
        return $this;
    }

    /**
     *
     */
    public function print()
    {
        foreach ($this->session as $key => $value) {
            $_SESSION[$key] = $value;
        }

        foreach ($this->cookie as $key => $value) {
            $this->setCookie($key, $value);
        }

        foreach ($this->header as $header) {
            header($header);
        }

        echo $this->html;
    }
}
