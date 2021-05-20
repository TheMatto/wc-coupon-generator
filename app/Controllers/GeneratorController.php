<?php

namespace Dominatus\CouponGenerator\Controllers;

use Dominatus\WordPress\Request;

class GeneratorController extends Controller
{
    public function generate(Request $request)
    {
        $quantity = $request->input('quantity');

        for ($i = 0; $i < 10; $i++) {
            $code = $this->generateCode(8);

            while (wc_get_coupon_id_by_code($code)) {
                $code = $this->generateCode(8);
            }

            $coupon = new \WC_Coupon();
            $coupon->set_code($code);
            $coupon->set_amount($request->input('amount'));
            $coupon->add_meta_data('_generator_made', 1, true);
            $coupon->save();
        }

        return [
            'success' => true
        ];
    }

    protected function generateCode(int $length)
    {
        return substr(str_shuffle(bin2hex(random_bytes(20))), 0, $length);
    }

    public function viewsEdit(Request $request, array $views)
    {
        $query = new \WP_Query([
            'post_type' => 'shop_coupon',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'meta_key' => '_generator_made',
            'meta_value' => 1
        ]);

        $views['generator'] = sprintf(
            '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>',
            get_admin_url() . '/edit.php?post_type=shop_coupon&generator_made',
            $request->has('generator_made') ? 'current' : '',
            __('Generator', 'wc-coupon-generator'),
            count($query->posts)
        );

        return $views;
    }

    public function parseQuery(Request $request, \WP_Query $query)
    {
        if (
            is_admin()
            && $request->query('post_type') == 'shop_coupon'
            && $request->has('generator_made')
        ) {
            $query->set('meta_query', [
                [
                    'key' => '_generator_made',
                    'value' => 1,
                    'compare' => '='
                ]
            ]);
        }

        return $query;
    }
}
