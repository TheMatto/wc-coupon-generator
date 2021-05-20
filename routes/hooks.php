<?php

use Dominatus\WordPress\Hook;
use Dominatus\CouponGenerator\Controllers\GeneratorController;

Hook::filter('views_edit-shop_coupon')
->any([GeneratorController::class, 'viewsEdit']);

Hook::filter('parse_query')
->any([GeneratorController::class, 'parseQuery']);
