<?php

namespace Dominatus\CouponGenerator;

use Dominatus\WordPress\View as BaseView;
use Dominatus\CouponGenerator\Store;

class View extends BaseView
{
    protected function __construct()
    {
        $this->templatePath = Store::get('MAIN_DIR_PATH') . '/resources/views';
        $this->cache = Store::get('PRODUCTION');

        $this->init();
    }
}
