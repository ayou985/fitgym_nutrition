<?php

namespace App\Controllers;

use App\Models\AllProduct;


class ProductController
{
    public function product()
    {
        $product = new AllProduct(null, null, null, null, null, null, null);
        $products = $product->getAll();
        require_once(__DIR__ . "/../Views/product.view.php");
    }
}
