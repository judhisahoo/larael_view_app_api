<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProductRepository implements ProductRepositoryInterface{

    public function getAllProducts(){
        return Product::get();
    }

    public function getPrducatById($product_id){
        return Product::where('id',$product_id)->get()->toArray();
    }

    public function deleteProduct($product_id){
        return Product::where('id',$product_id)->delete();
    }

    public function createProduct(array $userDetails){
        $productObj=new Product();
        $productObj->name=$userDetails['name'];
        $productObj->price=$userDetails['price'];
        $productObj->status=$userDetails['status'];
        $productObj->upc=$userDetails['upc'];
        $productObj->image=$userDetails['image'];
        $productObj->save();
        return $productObj->id;
    }

    public function updateProduct($product_id,array $newDetails){
        return Product::where('id',$product_id)->update($newDetails);
    }
}
