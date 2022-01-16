<?php

namespace App\Interfaces;

interface ProductRepositoryInterface{
    public function getAllProducts();
    public function getPrducatById($product_id);
    public function deleteProduct($product_id);
    public function createProduct(array $productDetails);
    public function updateProduct($product_id,array $updateDetails);
}
