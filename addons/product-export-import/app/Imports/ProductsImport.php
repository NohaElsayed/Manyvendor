<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Product;
use Auth;

class ProductsImport implements ToModel, WithStartRow
{

    /**
     * @return int
     */

    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param model $model
     */
    public function model(array $row)
    {

        if (Auth::user()->user_type === 'Admin') {
            return new Product([
                'id'    => $row[0],
                'slug'    => $row[1],
                'name'     => $row[2],
                'sku'     => $row[3],
                'short_desc'    => $row[4],
                'big_desc'    => $row[5],
                'brand_id'    => $row[6],
                'parent_id'    => $row[7],
                'category_id'    => $row[8],
                'image'    => $row[9],
                'video_url'    => $row[10],
                'provider'    => $row[11],
                'meta_title'    => $row[12],
                'meta_desc'    => $row[13],
                'meta_image'    => $row[14],
                'tags'    => $row[15],
                'is_request'    => $row[16] ?? 0,
                'have_variant'    => $row[17],
                'is_published'    => $row[18] ?? 1,
                'tax'    => $row[19],
                'product_price'    => $row[20],
                'purchase_price'    => $row[21],
                'is_discount'    => $row[22],
                'discount_type'    => $row[23],
                'discount_price'    => $row[24],
                'discount_percentage'    => $row[25],
                'created_at'    => $row[26],
                'updated_at'    => $row[27],
            ]);
        }


        if (Auth::user()->user_type === 'Vendor') {
            return new Product([
                'id'    => $row[0],
                'slug'    => $row[1],
                'name'     => $row[2],
                'sku'     => $row[3],
                'short_desc'    => $row[4],
                'big_desc'    => $row[5],
                'brand_id'    => $row[6],
                'parent_id'    => $row[7],
                'category_id'    => $row[8],
                'image'    => $row[9],
                'video_url'    => $row[10],
                'provider'    => $row[11],
                'meta_title'    => $row[12],
                'meta_desc'    => $row[13],
                'meta_image'    => $row[14],
                'tags'    => $row[15],
                'is_request'    => 1,
                'have_variant'    => $row[17],
                'is_published'    => 0,
                'tax'    => $row[19],
                'product_price'    => $row[20],
                'purchase_price'    => $row[21],
                'is_discount'    => $row[22],
                'discount_type'    => $row[23],
                'discount_price'    => $row[24],
                'discount_percentage'    => $row[25],
                'created_at'    => $row[26],
                'updated_at'    => $row[27],
            ]);
        }

    }
}