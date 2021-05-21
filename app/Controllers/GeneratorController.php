<?php

namespace Dominatus\CouponGenerator\Controllers;

use Dominatus\WordPress\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            $coupon->set_usage_limit(1);
            $coupon->set_discount_type('percent');
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

        $views['generator'] = $this->render('backend/views-edit', [
            'url' => 'edit.php?post_type=shop_coupon&generator_made',
            'current' => $request->has('generator_made'),
            'text' => __('Generator', 'wc-coupon-generator'),
            'count' => count($query->posts)
        ]);

        return $views;
    }

    public function parseQuery(Request $request, \WP_Query $query)
    {
        if (is_admin() && $request->query('post_type') == 'shop_coupon') {
            if ($request->has('generator_made')) {
                $query->set('meta_query', [
                    [
                        'key' => '_generator_made',
                        'value' => 1,
                        'compare' => '='
                    ]
                ]);
            }

            if ($request->has('export')) {
                $query->set('posts_per_page', -1);
            }
        }

        return $query;
    }

    public function exportXlsx(Request $request, array $posts)
    {
        if (
            is_admin()
            && $request->query('post_type') == 'shop_coupon'
            && $request->has('export')
        ) {
            $exportArray = [];

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            $worksheet->fromArray([
                [
                    'Koda kupona'
                ]
            ], null, 'A1');

            foreach ($posts as $index => $post) {
                $worksheet->fromArray([
                    [
                        $post->post_title
                    ]
                ], null, 'A' . ($index + 2));
            }

            $writer = new Xlsx($spreadsheet);

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="coupon-export.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');

            exit;
        }

        return $posts;
    }

    public function exportButton(Request $request, string $which)
    {
        if ($which === 'top' && $request->query('post_type') == 'shop_coupon') {
            return $this->render('backend/export-button', [
                'text' => __('Export', 'wc-coupon-generator'),
                'generatorMade' => $request->has('generator_made')
            ]);
        }
    }
}
