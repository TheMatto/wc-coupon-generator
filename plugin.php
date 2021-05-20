<?php

/**
 * Plugin Name: WooCommerce Coupon Generator
 * Description: Bulk generate WooCommerce coupons
 * Version: 1.0.0
 * Requires at least: 5.4
 * Requires PHP: 7.4
 * Author: Dominatus
 * Author URI: https://dominatus.si/
 * Text Domain: wc-coupon-generator
 * Domain Path: /lang
 *
 * WC requires at least: 5.0.0
 * WC tested up to: 5.3.0
 */

namespace Dominatus\CouponGenerator;

require_once __DIR__ . '/vendor/autoload.php';

use Dominatus\WordPress\ResourceManager;

Store::set('PRODUCTION', false);
Store::set('MAIN_DIR_PATH', plugin_dir_path(__FILE__));
Store::set('MAIN_DIR_URL', plugin_dir_url(__FILE__));
Store::set('MAIN_FILE', __FILE__);

require 'routes/api.php';
require 'routes/hooks.php';
require 'routes/ajax.php';
require 'routes/menu.php';

ResourceManager::addFrom(Store::get('MAIN_DIR_PATH') . '/dist/')
->webpackBundles('coupon-generator');
