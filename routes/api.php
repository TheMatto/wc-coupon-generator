<?php

use Dominatus\WordPress\RestRoute;
use Dominatus\CouponGenerator\Controllers\GeneratorController;

RestRoute::make('coupon-generator/v1', 'generate')
->post([GeneratorController::class, 'generate']);
