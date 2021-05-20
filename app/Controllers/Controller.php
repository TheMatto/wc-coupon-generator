<?php

namespace Dominatus\CouponGenerator\Controllers;

use Dominatus\WordPress\Singleton;
use Dominatus\CouponGenerator\View;

class Controller extends Singleton
{
    public function render(string $view, array $data = [])
    {
        return View::make($view, $data);
    }
}
