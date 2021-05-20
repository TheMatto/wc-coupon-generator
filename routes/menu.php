<?php

use Dominatus\WordPress\MenuPage;
use Dominatus\CouponGenerator\View;

MenuPage::make(function ($page) {
    $page->parent = 'woocommerce';
    $page->title = __('Coupon generator', 'wc-coupon-generator');

    $page->get(function () {
        return View::make('backend/generator');
    });
});
