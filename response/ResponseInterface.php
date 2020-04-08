<?php

namespace fw_micro\core\response;

/**
 * Interface ResponseInterface
 * @package fw_micro\core\response
 */
interface ResponseInterface
{
    public function setBody(string $html): self;
    public function setHeader(string $header): self;
    public function setCookie(string $key, $value): self;
    public function setSession(string $key, $value): self;
    public function print();
}
