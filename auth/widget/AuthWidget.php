<?php

namespace fw_micro\core\auth\widget;

use fw_micro\core\Widget;

/**
 * Class AuthWidget
 * @package fw_micro\core\auth\widget
 */
class AuthWidget extends Widget
{
    /**
     * @param array $config
     * @return string
     */
    public function begin(array $config = []): string
    {
        return $this->render(__DIR__ . '/auth.php', $config)->getHtml();
    }
}
