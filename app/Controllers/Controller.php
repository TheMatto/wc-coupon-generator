<?php

namespace Dominatus\CouponGenerator\Controllers;

use Dominatus\WordPress\{Singleton, View};
use Dominatus\CouponGenerator\Store;

class Controller extends Singleton
{
    protected View $view;

    protected function __construct()
    {
        $this->view = new View(
            Store::get('MAIN_DIR_PATH') . '/resources/views',
            Store::get('PRODUCTION')
        );
    }
}
