<?php

namespace Dominatus\CouponGenerator;

use Dominatus\WordPress\View as BaseView;
use Dominatus\CouponGenerator\Store;

class View extends BaseView
{
    protected function __construct()
    {
        $this->templatePath = Store::get('MAIN_DIR_PATH') . '/resources/views';
        $this->cachePath = Store::get('MAIN_DIR_PATH') . '/resources/views/cache';
        $this->cacheEnabled = Store::get('PRODUCTION');

        $this->init();
    }
}
