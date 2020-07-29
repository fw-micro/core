<?php


namespace fw_micro\core\auth\widget;


use fw_micro\core\Widget;

class RegisterWidget extends Widget
{

    public function begin(array $config = []): string
    {
        return $this->render(__DIR__ . '/register.php', $config)->getHtml();
    }
}